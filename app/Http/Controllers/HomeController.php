<?php

namespace App\Http\Controllers;

use App\album;
use App\artist;
use App\invoice;
use App\invoiceline;
use App\modification;
use App\reproductions;
use App\roles_relations;
use App\shoppingCart;
use App\track;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Laracsv\Export;
use League\Csv\CannotInsertRecord;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {

        $user = Auth::user();
        return view('home', compact('user'));
    }


    /**
     * Create a new profile interface
     *
     * @return Application|Factory|View
     */
    public function profile()
    {

        $user = Auth::user();

        $user_id = $user->id;

        $userChecker = DB::table('roles_relations')
            ->where('id_user', $user_id)
            ->count();

        $userRole = roles_relations::find($user_id);

        if ($userChecker < 1) {
            $roles_relations = new roles_relations;
            $roles_relations->id_user = $user_id;
            $roles_relations->id_roles = 5;
            $roles_relations->save();
        }

        //        Returns the current role of the user
        $role = $userRole->id_roles;
        $user_role = DB::table('roles')
            ->where('id', $role)
            ->first();

        $roleValue = $user_role->name;
        $ownedTracks = DB::table('invoiceline')
            ->join('invoice', 'invoiceline.invoiceid', '=', 'invoice.invoiceid')
            ->join('track', 'track.trackid', '=', 'invoiceline.trackid')
            ->join('album', 'track.albumid', '=', 'album.albumid')
            ->join('artist', 'artist.artistid', '=', 'album.artistid')
            ->selectRaw(DB::raw('artist.name AS artistName, album.title AS albumTitle, track.trackid AS trackId, track.name AS trackName, track.url AS trackURL'))
            ->where('invoice.customerid', '=', $user->id)
            ->get();

        return view('profile_information', compact('user', 'roleValue', 'ownedTracks'));
    }


    /**
     * Search for a new query word
     *
     * @param int $searcher
     * @param     $word         Word to be searched
     * @return Application|Factory|View
     */
    public function search($searcher = 1, $word)
    {
        $word_decoded = urldecode($word);
        $word_decoded = Str::replaceArray('|', ['/'], $word_decoded);

        //Query for search on artists -> Must return the Artist name
        /** @var artist $artists */
        $artists = DB::table('artist')
            ->where('name', $word_decoded)
            ->get();

        /** @var album $albums */
        $albums = DB::table('album')
            ->join('artist', 'album.artistid', '=', 'artist.artistid')
            ->selectRaw(DB::raw('artist.name as artist, album.title as title, album.albumid as id'))
            ->where('album.title', $word_decoded)
            ->orWhere('artist.name', $word_decoded)
            ->get();

        /** @var track $tracks */
        $tracks = DB::table('track')
            ->join('album', 'track.albumid', '=', 'album.albumid')
            ->join('artist', 'album.artistid', '=', 'artist.artistid')
            ->join('mediatype', 'track.mediatypeid', '=', 'mediatype.mediatypeid')
            ->join('genre', 'track.genreid', '=', 'genre.genreid')
            ->selectRaw(DB::raw('track.trackid as trackid, track.name as track, album.title as album, artist.name as artist, mediatype.name as media, genre.name as genre, track.composer as composer, track.milliseconds as duration, track.bytes as size, track.unitprice as price'))
            ->where('hidden_status', '!=', '1')
            ->where('track.name', '=', $word_decoded)
            ->orWhere('album.title', '=', $word_decoded)
            ->orWhere('artist.name', '=', $word_decoded)
            ->orWhere('genre.name', '=', $word_decoded)
            ->orWhere('mediatype.name', '=', $word_decoded)
            ->orWhere('track.composer', '=', $word_decoded)
            ->get();


        return view('searchQuery', compact('artists', 'albums', 'tracks'));


    }

    // Registration

    /**
     * Return the Info Registration View
     *
     * @return Application|Factory|View
     */
    public function newInfoRegistration()
    {
        $user = Auth::user();
        return view('registration_form', compact('user'));
    }


    /**
     * Change User information
     *
     * @return Application|Factory|View
     */
    public function userChanges()
    {
        //        Authenticate User
        $user = Auth::user();
        $username = $user->name;
        $userQuery = DB::table('users')
            ->join('roles_relations', 'users.id', '=', 'roles_relations.id_user')
            ->where('users.name', $username)
            ->first();
        $userRole = $userQuery->id_roles;


        $userRoles = DB::table('users')
            ->join('roles_relations', 'users.id', '=', 'roles_relations.id_user')
            ->join('roles', 'roles_relations.id_roles', '=', 'roles.id')
            ->selectRaw(DB::raw('users.id as userid, users.name as username, roles.id as roleid, roles.name as rolename'))
            ->orderBy('users.id')
            ->get();

        $roles = DB::table('roles')->get();

        if ($userRole != 1) {
            return view('Error405');
        } else return view('userChanges', compact('userRoles', 'roles'));
    }


    /**
     * Generate statistics
     *
     * @return Application|Factory|View
     */
    public function statistics()
    {
        $artist_table = DB::table('artist');
        $album_table = DB::table('album');

        //        Top 5 Artists
        $top5Artists = DB::table('artist')
            ->join('album', 'artist.artistid', '=', 'album.artistid')
            ->select(DB::raw(' artist.name, COUNT(album.albumid) as albums'))
            ->groupBy('artist.name')
            ->orderBy('albums', 'desc')
            ->limit(5)
            ->get();

        //        Genre with most songs
        $genreMostSongs = DB::table('genre')
            ->join('track', 'track.genreid', '=', 'genre.genreid')
            ->selectRaw(DB::raw('genre.name, COUNT(track.genreid) as counter'))
            ->groupBy('genre.name')
            ->orderBy('counter', 'desc')
            ->limit(5)
            ->get();


        //        Playlist Duration
        $playlistDuration = DB::table('playlist')
            ->join('playlisttrack', 'playlist.playlistid', '=', 'playlisttrack.playlistid')
            ->join('track', 'playlisttrack.trackid', '=', 'track.trackid')
            ->selectRaw(DB::raw('playlist.name, sum(track.milliseconds) as duration'))
            ->groupBy('playlist.name')
            ->orderBy('duration', 'desc')
            ->get();


        //        Longest Songs
        $longestSongs = DB::table('playlist')
            ->join('playlisttrack', 'playlist.playlistid', '=', 'playlisttrack.playlistid')
            ->join('track', 'playlisttrack.trackid', '=', 'track.trackid')
            ->selectRaw(DB::raw('track.name, sum(track.milliseconds) as duration'))
            ->groupBy('track.name')
            ->orderBy('duration', 'desc')
            ->limit(5)
            ->get();
        //        User with the most submitted songs
        $userSubmitted = DB::table('users')
            ->join('track', 'users.id', '=', 'track.added_by')
            ->selectRaw(DB::raw('users.name, count(*) as submitted'))
            ->groupBy('users.name')
            ->orderBy('submitted')
            ->limit(5)
            ->get();


        //        Average per Genre
        $avgGenre = DB::table('genre')
            ->join('track', 'track.genreid', '=', 'genre.genreid')
            ->selectRaw(DB::raw('genre.name, round(avg(track.milliseconds), 2) as average'))
            ->groupBy('genre.name')
            ->orderBy('average', 'desc')
            ->get();

        //        Quantity per playlist
        $artistPerPlaylist = DB::table('playlist')
            ->join('playlisttrack', 'playlist.playlistid', '=', 'playlisttrack.playlistid')
            ->join('track', 'playlisttrack.trackid', '=', 'track.trackid')
            ->join('album', 'track.albumid', '=', 'album.albumid')
            ->join('artist', 'album.artistid', '=', 'artist.artistid')
            ->selectRaw(DB::raw('DISTINCT playlist.name, COUNT(artist.name) as counter'))
            ->groupBy('playlist.name')
            ->orderBy('counter', 'desc')
            ->get();

        //        Genre Diversity
        $genreDiversity = DB::table('artist')
            ->join('album', 'album.artistid', '=', 'artist.artistid')
            ->join('track', 'album.albumid', '=', 'track.albumid')
            ->join('genre', 'track.genreid', '=', 'genre.genreid')
            ->selectRaw(DB::raw('artist.name, COUNT(track.genreid) as counter'))
            ->groupBy('artist.name')
            ->orderBy('counter', 'desc')
            ->limit(5)
            ->get();


        return view('outputFile', compact('top5Artists', 'genreMostSongs', 'longestSongs', 'playlistDuration', 'avgGenre', 'artistPerPlaylist', 'genreDiversity', 'userSubmitted'));
    }


    /**
     * Return the delete form view
     *
     * @return Application|Factory|View
     */
    public function deletePage()
    {
        return view('delete_form');
    }


    /**
     * Return the hide a song view
     *
     * @return Application|Factory|View
     */
    public function hideSong()
    {
        $user = Auth::user();

        $username = $user->name;


        $userQuery = DB::table('users')
            ->join('roles_relations', 'users.id', '=', 'roles_relations.id_user')
            ->where('users.name', $username)->first();
        $userRole = $userQuery->id_roles;

        if ($userRole != 1) {
            return view('Error405');
        } else return view('hideSongForm');
    }


    /**
     * Hides a song
     *
     * @param $artist Artist's song
     * @param $album  Album's song
     * @param $track  Song to be hidden
     * @return RedirectResponse
     */
    public function hideTheSongMethod($artist, $album, $track)
    {
        //        Get the data from the URL
        $artist_name = urldecode($artist);
        $artist_name = Str::replaceArray('|', ['/'], $artist_name);
        $album_name = urldecode($album);
        //        print($album_name);
        $album_name = Str::replaceArray('|', ['/'], $album_name);
        //        print($album_name_formated);
        $track_name = urldecode($track);
        $track_name = Str::replaceArray('|', ['/'], $track_name);

        //        Get Artist id
        //        $idGetter = DB::table('artist')->where('name', $artist_name)->first();
        $updatingTable = DB::table('artist')
            ->join('album', 'artist.artistid', '=', 'album.artistid')
            ->join('track', 'album.albumid', '=', 'track.albumid')
            ->where('artist.name', $artist_name)
            ->where('album.title', $album_name)
            ->where('track.name', $track_name)->first();


        $id_track = $updatingTable->trackid;
        $finder = track::find($id_track);
        if ($finder->hidden_status == 1) {
            $finder->hidden_status = 0;
            $finder->save();
        } elseif ($finder->hidden_status == 0) {
            $finder->hidden_status = 1;
            $finder->save();
        }
        return redirect()->action('HomeController@profile');
    }

    /**
     * Deletes a user
     *
     * @param $userID user to be deleted
     * @return Application|Factory|RedirectResponse|View
     */
    public function deleteUser($userID)
    {
        $user = Auth::user();

        $username = $user->name;


        $userQuery = DB::table('users')
            ->join('roles_relations', 'users.id', '=', 'roles_relations.id_user')
            ->where('users.name', $username)->first();
        $userRole = $userQuery->id_roles;

        if ($userRole != 1) {
            return view('Error405');
        }
        DB::table('users')->where('id', $userID)->delete();

        return redirect()->action('HomeController@userChanges');
    }


    /**
     * Returns a change roles view
     *
     * @return Application|Factory|RedirectResponse|View
     */
    public function changeRoles()
    {
        $user = Auth::user();

        $username = $user->name;


        $userQuery = DB::table('users')
            ->join('roles_relations', 'users.id', '=', 'roles_relations.id_user')
            ->where('users.name', $username)->first();
        $userRole = $userQuery->id_roles;
        if ($userRole != 1) {
            return view('Error405');
        } else {
            return redirect()->action('HomeController@userChanges');
        }
    }

    /**
     *
     * @param $userID      User id to be used
     * @param $roleChanged User role to be given
     * @return Application|Factory|RedirectResponse|View
     */
    public function rolechange($userID, $roleChanged)
    {
        $user = Auth::user();
        $username = $user->name;
        $userQuery = DB::table('users')
            ->join('roles_relations', 'users.id', '=', 'roles_relations.id_user')
            ->where('users.name', $username)->first();
        $userRole = $userQuery->id_roles;

        if ($userRole != 1) {
            return view('Error405');
        }

        $roleTable = new roles_relations;
        $control = DB::table('roles_relations')->where('id_user', $userID)->get();
        DB::table('roles_relations')->where('id_user', $userID)->delete();
        DB::table('roles_relations')->insert(['id_user' => $userID, 'id_roles' => (int)$roleChanged]);
        $control2 = DB::table('roles_relations')->where('id_user', $userID)->get();
        return redirect()->action('HomeController@changeRoles');
    }


    /**
     * Returns the updateInfo view
     *
     * @return Application|Factory|View
     */
    public function UpdateInfoEntrance()
    {
        $user = Auth::user();
        $username = $user->name;
        $userQuery = DB::table('users')
            ->join('roles_relations', 'users.id', '=', 'roles_relations.id_user')
            ->where('users.name', $username)->first();
        $userRole = $userQuery->id_roles;
        if ($userRole != 1) return view('Error405');

        return view('updateInfo');
    }

    /**
     * Generates an CSV to be used
     *
     * @return CSVObject
     * @throws CannotInsertRecord
     */
    public function generateCSV()
    {
        $invoice = DB::table("invoice")->get();
        $csvExporter = new Export();
        $csvExporter->build($invoice, ['invoiceid', 'customerid', 'invoicedate', 'billingaddress', 'billingcity', 'billingstate', 'billingcountry', 'billingpostalcode', 'total'])->download();

    }

    public function generateCSVAdmins(Request $request)
    {
        $request_type = $request->download;

        if ($request_type == 1) {
            $dateOne = $request->firstDate;
            $dateTwo = $request->secondDate;
            $find_sales = DB::select('SELECT * FROM showData(?, ?)', array($dateOne, $dateTwo));
            $find_sales = collect($find_sales);
            $csvExporter = new Export();
            $csvExporter->build($find_sales, ['year_number', 'month_number', 'week_number', 'total_sales'])->download();

        } else if ($request_type == 2) {
            $dateOne = $request->firstDate;
            $dateTwo = $request->secondDate;
            $limiter = $request->limiter;
            $find_artist = DB::select('SELECT * FROM bestArtists(?, ?, ?)', array($dateOne, $dateTwo, $limiter));
            $find_artist = collect($find_artist);
            $csvExporter = new Export();
            $csvExporter->build($find_artist, ['id', 'artist_name', 'total_sales'])->download();

        } else if ($request_type == 3) {
            $dateOne = $request->firstDate;
            $dateTwo = $request->secondDate;
            $find_genre = DB::select('SELECT * FROM bestGenres(?, ?)', array($dateOne, $dateTwo));
            $find_genre = collect($find_genre);
            $csvExporter = new Export();
            $csvExporter->build($find_genre, ['genre_name', 'total_sales'])->download();

        } else if ($request_type == 4) {
            $artistName = $request->artist;
            $limiter = (int)$request->limiter;
            $queue_artist = DB::select('SELECT * FROM bestTracks(?, ?)', array($artistName, $limiter));
            $queue_artist = collect($queue_artist);
            $csvExporter = new Export();
            $csvExporter->build($queue_artist, ['album_title', 'track_title', 'reproduced'])->download();

        }

    }


    /**
     * Adds a new entry to the database for artist, album or track
     *
     * @param Request $request Request that has the artist, the album, and/or the track
     * @return Exception|Application|Factory|QueryException|RedirectResponse|View|string
     */
    public function addSomething(Request $request)
    {
        $addingType = $request->get('select_category');
        if ($addingType == 'empty') {
            return view('PageNotFound');
        } else if ($addingType == 'artist') {
            DB::beginTransaction();
            try {
//                $mod_table = new modification();
                $user = Auth::user();
                $userid = $user->id;

                $artist_name_formated = $request->get('artist');

                $artist = new artist;
                $artistCount = DB::table('artist')->orderBy('artistid', 'desc')->first();
                $artistidsum = $artistCount->artistid;
                $artist->artistid = $artistidsum + 1;
                $artist->name = $artist_name_formated;
                $artist->save();

                DB::commit();
            } catch (QueryException $exception) {
                DB::rollBack();
                return $exception;
            }
        } else if ($addingType == 'album') {
            //        Get the Post Values
            $artist_name_formated = $request->get('artist');
            $album_name_formated = $request->get('album');

            //        Instantiate table
            $album_table = new album;
            ////        Check how many albums exist already
            $album_count = DB::table('album')->orderBy('artistid', 'desc')->first();
            $albumidsum = $album_count->albumid;
            ////        Check if the artist exists or not (value must be higher than 0)
            $artistExists = DB::table('artist')->where('name', $artist_name_formated)->count();
            ////        Get the id of the artist
            $idGetter = DB::table('artist')->where('name', $artist_name_formated)->first();
            ////        Store the id of the artist
            $idStorer = $idGetter->artistid;
            //
            if ($artistExists > 0) {
                DB::beginTransaction();
                try {
                    $album_table->albumid = $albumidsum + 1;
                    $album_table->title = $album_name_formated;
                    $album_table->artistid = $idStorer;
                    $album_table->save();

                    DB::commit();
                } catch (QueryException $exception) {
                    DB::rollBack();
                    return $exception;
                }
            } else {
                print('Artist not found. Couldn\'t add album.');
            }
        } else if ($addingType == 'cancion') {

            // Get data from POST
            $artist_name_formated = $request->get('artist');
            $album_name_formated = $request->get('album');
            $track_name_formated = $request->get('track');
            $track_url_formatted = $request->get('url');


            ////        ARTIST SECTION
            ////        check if the artist exists (count must be larger than 0)
            $artistExists = DB::table('artist')->where('name', $artist_name_formated)->count();
            ////        Get the id of the artist
            $id_artist_getter = DB::table('artist')->where('name', $artist_name_formated)->first();
            ////        Store the ID

            if ($id_artist_getter == null) {
                return "Artist not found";
            }
            $id_artist = $id_artist_getter->artistid;
            //
            ////        ALBUM SECTION
            ////        Check if the album exists or not (count must be larger than 0)
            $albumExists = DB::table('album')->where('title', $album_name_formated)->count();
            print($albumExists);
            ////        Get the ID of the album
            $id_album_getter = DB::table('album')->where('title', $album_name_formated)->first();
            ////        Store the value of the ID
            print(var_dump($id_album_getter));
            if ($id_album_getter == null) {
                return "Album not found";
            }
            $id_album = $id_album_getter->albumid;
            print($id_album);
            ////        Check if the Album belongs to the artist (Count must be larger than 0)
            $albumBelongsToArtist = DB::table('artist')
                ->join('album', 'album.artistid', '=', 'artist.artistid')
                ->count();
            print($albumBelongsToArtist);

            //        TRACK SECTION
            //       Count how many tracks there are
            $trackid = DB::table('track')
                ->orderBy('trackid', 'desc')
                ->first();

            $idtrack = $trackid->trackid;


            /** Inserts the track to the table */
            if ($artistExists > 0) {
                if ($albumExists > 0) {
                    if ($albumBelongsToArtist > 0) {
                        DB::beginTransaction();
                        try {
                            // Instantiate the other tables
                            $user = Auth::user();
                            $user_id = $user->id;

                            $track_table = new track();
                            $invoice_table = new invoice();
                            $invoiceline_table = new invoiceline();


                            // Insert into the track table

                            $track_table->trackid = $idtrack + 1;
                            $track_table->name = $track_name_formated;
                            $track_table->albumid = $id_album;
                            $track_table->mediatypeid = 1;
                            $track_table->genreid = $request->get('genre');
                            $track_table->composer = null;
                            $track_table->milliseconds = rand(80000, 300000);
                            $track_table->bytes = rand(90000, 300000);
                            $track_table->unitprice = 0.99;
                            $track_table->hidden_status = 0;
                            $track_table->added_by = $user_id;
                            $track_table->url = $track_url_formatted;
                            $track_table->save();

                            // Insert into the invoice table
                            $invoiceid = DB::table('invoice')
                                ->orderBy('invoiceid', 'desc')
                                ->first();

                            $idinvoice = $invoiceid->invoiceid;
                            $invoice_table->invoiceid = $idinvoice + 1;
                            $invoice_table->customerid = $user_id;
                            $invoice_table->billingaddress = null;
                            $invoice_table->billingcity = null;
                            $invoice_table->billingstate = null;
                            $invoice_table->billingcountry = null;
                            $invoice_table->billingpostalcode = null;
                            $invoice_table->total = 0.0;
                            $invoice_table->save();

                            // Insert into InvoiceLine Table
                            $invoicelineid = DB::table('invoiceline')
                                ->orderBy('invoicelineid', 'desc')
                                ->first();

                            $idinvoiceline = $invoicelineid->invoicelineid;
                            $invoiceline_table->invoicelineid = $idinvoiceline + 1;
                            $invoiceline_table->invoiceid = $idinvoice + 1;
                            $invoiceline_table->trackid = $idtrack + 1;
                            $invoiceline_table->unitprice = 0.0;
                            $invoiceline_table->quantity = 1;
                            $invoiceline_table->save();

                            DB::COMMIT();
                        } catch (QueryException $exception) {
                            DB::rollBack();
                            return $exception;
                        }
                    } else {
                        return "The Album does not belong to the artist";
                    }
                } else return "The album doesn't exist";
            } else {
                return "The artist doesn\'t exist";
            }
        }
        return redirect()->action('HomeController@profile');
    }

    /**
     * Deletes an entry from the database for artist, album or track
     *
     * @param Request $request Request that has the artist, the album, and/or the track to be deleted.
     * @return array|Exception|QueryException|RedirectResponse|string
     */
    public function deleteSomething(Request $request)
    {
        $deletingRequest = $request->get('select_category');
        if ($deletingRequest == 'artist') {
            DB::beginTransaction();
            try {
                $artist_name_formated = $request->get('artist');//        Check if the artist exists
                $artistExists = DB::table('artist')
                    ->where('name', $artist_name_formated)
                    ->count();
                if ($artistExists < 1) return 'This artist does not exist! (Check your caps)';//        Get the table that has all the tracks
                $tracks = DB::table('artist')
                    ->join('album', 'artist.artistid', '=', 'album.artistid')
                    ->join('track', 'album.albumid', '=', 'track.albumid')
                    ->where('artist.name', $artist_name_formated)
                    ->get();//        Get the table that has all the albums
                $albums = DB::table('artist')
                    ->join('album', 'artist.artistid', '=', 'album.artistid')
                    ->where('artist.name', $artist_name_formated)
                    ->get();//        Get the table with the artist name
                $track_table = DB::table('track');
                $album_table = DB::table('album');
                $artist_table = DB::table('artist');
                foreach ($tracks as $track) {
                    $id = $track->trackid;
                    $trackName = $track->name;

                    $mod_table = new modification();
                    $user = Auth::user();
                    $userid = $user->id;
                    $mod_table->modification_type = 1;  // 1 = Deletion ; 2 = Update; 3 = Creation
                    $mod_table->modified_type = 1;      // 1 = Track; 2 = Album; 3 = Artist
                    $mod_table->modified_id = $id;
                    $mod_table->user_id = $userid;
                    $mod_table->name_of_affected = $trackName;
                    $mod_table->save();
                }
                foreach ($albums as $album) {
                    $id = $album->albumid;
                    $name = $album->title;

                    $mod_table = new modification();
                    $user = Auth::user();
                    $userid = $user->id;
                    $mod_table->modification_type = 1;  // 3 = Creation of something
                    $mod_table->modified_type = 2;      // 3 = artist
                    $mod_table->modified_id = $id;
                    $mod_table->user_id = $userid;
                    $mod_table->name_of_affected = $name;

                    $mod_table->save();

                    DB::table('track')->where('albumid', $id)->delete();
                    $album_table->where('albumid', $id)->delete();
                    //                        DB::commit();
                }//                DB::beginTransaction();
                $artistGetter = DB::table('artist')->where('name', $artist_name_formated)->first();
                $idArtist = $artistGetter->artistid;//                $mod_table = new modification();
                $user = Auth::user();
                $userid = $user->id;//
                //                $mod_table->modification_type = 1;  // 1 = Deletion ; 2 = Update; 3 = Creation
                $mod_table->modified_type = 3;      // 1 = Track; 2 = Album; 3 = Artist
                $mod_table->modified_id = $idArtist;
                $mod_table->user_id = $userid;
                $mod_table->name_of_affected = $artist_name_formated;
                $mod_table->save();
                DB::table('artist')
                    ->where('name', $artist_name_formated)->delete();
                DB::commit();
            } catch (QueryException $e) {
                DB::rollBack();
                return $e;
            }


        } else
            if ($deletingRequest == 'album') {
                DB::beginTransaction();
                try {
                    $artist_name_formated = $request->get('artist');
                    $album_name_formated = $request->get('album');

                    //        Check if the album belongs
                    $album_belong = DB::table('album')
                        ->join('artist', 'album.artistid', '=', 'artist.artistid')
                        ->where('album.title', $album_name_formated)
                        ->where('artist.name', $artist_name_formated)
                        ->count();

                    if ($album_belong < 1) return 'Album doesn\'t exist!';

                    //        Get the album id to delete all the tracks
                    $id_album = DB::table('album')
                        ->join('artist', 'album.artistid', '=', 'artist.artistid')
                        ->where('album.title', $album_name_formated)
                        ->where('artist.name', $artist_name_formated)
                        ->first();
                    $id_album = $id_album->albumid;


                    $trackTable = new track();
                    $tracks = DB::table('track')->where('albumid', $id_album)->get();

                    foreach ($tracks as $track) {

                        $id = $track->trackid;
                        $trackName = $track->name;

                        $mod_table = new modification();
                        $user = Auth::user();
                        $userid = $user->id;
                        $mod_table->modification_type = 1;  // 1 = Deletion ; 2 = Update; 3 = Creation
                        $mod_table->modified_type = 1;      // 1 = Track; 2 = Album; 3 = Artist
                        $mod_table->modified_id = $id;
                        $mod_table->user_id = $userid;
                        $mod_table->name_of_affected = $trackName;
                        $mod_table->save();

                        $trackTable->where('trackid', $id)->delete();
                    }

                    $mod_table->modification_type = 1;
                    $mod_table->modified_type = 2;
                    $mod_table->modified_id = $id_album;
                    $mod_table->user_id = $userid;
                    $mod_table->name_of_affected = $album_name_formated;
                    $mod_table->save();

                    DB::table('album')->where('title', $album_name_formated)->delete();
                    DB::commit();
                } catch (QueryException $exception) {
                    DB::rollback();
                    return $exception;
                }
            } else if ($deletingRequest == 'cancion') {
                DB::beginTransaction();
                try {
                    //        Decode URLs
                    $artist_name_formated = $request->get('artist');
                    $album_name_formated = $request->get('album');
                    $track_name_formated = $request->get('track');

                    //        Instantiate the table
                    $trackTable = DB::table('track');

                    //        Check if track exists
                    $trackExists = DB::table('track')->where('name', $track_name_formated)
                        ->count();
                    //        Check if track belongs to Artist
                    $trackBelongs = DB::table('track')
                        ->join('album', 'track.albumid', '=', 'album.albumid')
                        ->join('artist', 'album.artistid', '=', 'artist.artistid')
                        ->where('track.name', $track_name_formated)
                        ->where('album.title', $album_name_formated)
                        ->where('artist.name', $artist_name_formated)
                        ->count();

                    if ($trackBelongs < 1) return [$artist_name_formated, $album_name_formated, $track_name_formated];

                    $trackId = $trackTable->where('name', '=', $track_name_formated)->first();

                    $user = Auth::user();
                    $userid = $user->id;
                    $mod_table = new modification();
                    $mod_table->modification_type = 1;
                    $mod_table->modified_type = 1;
                    $mod_table->modified_id = $trackId->trackid;
                    $mod_table->user_id = $userid;
                    $mod_table->name_of_affected = $trackId->name;
                    $mod_table->save();
                    //        Delete Track
                    $trackTable->where('name', '=', $track_name_formated)->delete();

                    DB::commit();
                } catch (QueryException $exception) {
                    DB::rollBack();
                    return $exception;
                }
            }
        return redirect()->action('HomeController@profile');
    }

    /**
     * Updates the name of an artist, an album or a track inside of the database.
     *
     * @param Request $request Request that has the artist's, album's or track's old and new names
     * @return Exception|Application|Factory|QueryException|RedirectResponse|View
     */
    public function updateSomething(Request $request)
    {
        $updateRequest = $request->get('select_category');
        if ($updateRequest == 'artist') {
            DB::beginTransaction();
            try {
                $old_artist = $request->get('oldArtist');
                $artist_name_formated = $request->get('newArtist');


                $user = Auth::user();
                $username = $user->name;
                $userQuery = DB::table('users')
                    ->join('roles_relations', 'users.id', '=', 'roles_relations.id_user')
                    ->where('users.name', $username)->first();
                $userRole = $userQuery->id_roles;
                if ($userRole != 1) return view('Error405');

                $artistGetter = DB::table('artist')->where('name', $old_artist)->first();
                $artistGetter = $artistGetter->artistid;

//                $mod_table = new modification();
                $userid = $user->id;
//                $mod_table->modification_type = 2;  // 1 = Deletion ; 2 = Update; 3 = Creation
//                $mod_table->modified_type = 3;      // 1 = Track; 2 = Album; 3 = Artist
//                $mod_table->modified_id = $artistGetter;
//                $mod_table->user_id = $userid;
//                $mod_table->save();

                DB::table('artist')->where('name', $old_artist)->update([
                    'name' => $artist_name_formated
                ]);
            } catch (QueryException $exception) {
                DB::rollback();
                return $exception;
            }
        } else if ($updateRequest == 'album') {
            DB::beginTransaction();
            try {
                $artist_name_formated = $request->get('artist');
                $album_name_formated = $request->get('oldAlbum');
                $album_new_name_formated = $request->get('newAlbum');

                $user = Auth::user();
                $username = $user->name;
                $userQuery = DB::table('users')
                    ->join('roles_relations', 'users.id', '=', 'roles_relations.id_user')
                    ->where('users.name', $username)->first();
                $userRole = $userQuery->id_roles;
                if ($userRole != 1) return view('Error405');


                $albumGetter = DB::table('album')->where('artist.name', $artist_name_formated)->where('album.title', $album_name_formated)->first();
                $albumGetter = $albumGetter->albumid;

//                $mod_table = new modification();
                $userid = $user->id;
//                $mod_table->modification_type = 2;  // 1 = Deletion ; 2 = Update; 3 = Creation
//                $mod_table->modified_type = 2;      // 1 = Track; 2 = Album; 3 = Artist
//                $mod_table->modified_id = $albumGetter;
//                $mod_table->user_id = $userid;
//                $mod_table->save();

                DB::table('album')
                    ->join('artist', 'album.artistid', '=', 'artist.artistid')
                    ->where('artist.name', $artist_name_formated)->where('album.title', $album_name_formated)->update([
                        'album.title' => $album_new_name_formated
                    ]);
                DB::commit();
            } catch (QueryException $exception) {
                DB::rollback();
                return $exception;
            }
        } else if ($updateRequest == 'cancion') {
            DB::beginTransaction();
            try {
                $artist_formated = $request->get('artist');
                $AlbumFormated = $request->get('album');
                $oldTrackFormated = $request->get('oldTrack');
                $newTrackFormated = $request->get('newTrack');

                $user = Auth::user();
                $username = $user->name;
                $userQuery = DB::table('users')
                    ->join('roles_relations', 'users.id', '=', 'roles_relations.id_user')
                    ->where('users.name', $username)->first();
                $userRole = $userQuery->id_roles;
                if ($userRole != 1) return view('Error405');

                $idGetter = DB::table('track')
                    ->join('album', 'album.albumid', '=', 'track.albumid')
                    ->join('artist', 'artist.artistid', '=', 'album.artistid')
                    ->where('artist.name', $artist_formated)
                    ->where('album.title', $AlbumFormated)
                    ->where('track.name', $oldTrackFormated)->first();

                $idGetter = $idGetter->trackid;

//                $mod_table = new modification();
                $userid = $user->id;
//                $mod_table->modification_type = 2;  // 1 = Deletion ; 2 = Update; 3 = Creation
//                $mod_table->modified_type = 1;      // 1 = Track; 2 = Album; 3 = Artist
//                $mod_table->modified_id = $idGetter;
//                $mod_table->user_id = $userid;
//                $mod_table->save();


                $checker = DB::table('track')
                    ->join('album', 'album.albumid', '=', 'track.albumid')
                    ->join('artist', 'artist.artistid', '=', 'album.artistid')
                    ->where('artist.name', $artist_formated)
                    ->where('album.title', $AlbumFormated)
                    ->where('track.name', $oldTrackFormated)
                    ->update([
                        'track.name' => $newTrackFormated
                    ]);

                DB::commit();
            } catch (QueryException $exception) {
                DB::rollback();
                return $exception;
            }
        }
        return redirect()->action('HomeController@profile');
    }

    /**
     * Mongo function that allows items to be added to the shopping cart, using a simple creation command into the
     * MongoDB
     *
     * @param Request $request Items to be pushed into the database
     * @return RedirectResponse
     */
    public function addTrackToShoppingCart(Request $request)
    {
        $mongoShoppingCart = new shoppingCart();
        $data = $request->trackId;
        $user = Auth::user();

        // Find the artist
        $artist = DB::table('artist')
            ->join('album', 'album.artistid', '=', 'artist.artistid')
            ->join('track', 'track.albumid', '=', 'album.albumid')
            ->where('track.trackid', '=', $data)
            ->selectRaw(DB::raw('artist.name AS artistName, album.title AS albumTitle, track.name AS trackName, track.trackid as trackid'))
            ->first();

        $artistName = $artist->artistname;
        $albumName = $artist->albumtitle;
        $trackId = $artist->trackid;
        $trackName = $artist->trackname;

        $mongoShoppingCart->username = $user->name;
        $mongoShoppingCart->artist = $artistName;
        $mongoShoppingCart->album = $albumName;
        $mongoShoppingCart->track = $trackName;
        $mongoShoppingCart->trackid = $trackId;

        $mongoShoppingCart->save();

        return redirect()->action('HomeController@searchQuery');
    }

    public function buyTrackPass(Request $request)
    {
        $trackid = $request->trackid;
        $checker = $this->buyTrack($trackid);
        if ($checker == false) return print('Couldn\'t buy this from your cart');
        $this->deleteFromShoppingCartMakeshift($trackid);
        return redirect()->action('HomeController@displayShoppingCart');
    }

    /**
     * Function that allows for a track to be added to the database of "obtained tracks"
     *
     * @param int $trackId
     * @return bool|Exception|QueryException
     */
    public function buyTrack(int $trackId)
    {
        $invoiceTable = new invoice();
        $invoiceLineTable = new invoiceline();
        $invoiceTrack = $trackId;

        $user = Auth::user();
        $userid = $user->id;

        $price = DB::table('track')
            ->selectRaw(DB::raw('unitprice'))
            ->where('trackid', '=', $invoiceTrack)
            ->first();
        $priceGetter = $price->unitprice;


        DB::beginTransaction();
        try {
            $invoiceid = DB::table('invoice')
                ->orderBy('invoiceid', 'desc')
                ->first();

            $idinvoice = $invoiceid->invoiceid;

            $invoiceTable->invoiceid = $idinvoice + 1;
            $invoiceTable->customerid = $userid;
            $invoiceTable->billingaddress = null;
            $invoiceTable->billingcity = null;
            $invoiceTable->billingstate = null;
            $invoiceTable->billingcountry = null;
            $invoiceTable->billingpostalcode = null;
            $invoiceTable->total = $priceGetter;
            $invoiceTable->save();

            $idInvoiceLine = DB::table('invoiceline')
                ->orderBy('invoicelineid', 'desc')
                ->first();

            $idInvoiceLine = $idInvoiceLine->invoicelineid;

            $invoiceLineTable->invoicelineid = $idInvoiceLine + 1;
            $invoiceLineTable->invoiceid = $idinvoice + 1;
            $invoiceLineTable->trackid = $invoiceTrack;
            $invoiceLineTable->unitprice = $priceGetter;
            $invoiceLineTable->quantity = 1;
            $invoiceLineTable->save();
            DB::commit();
        } catch (QueryException $exception) {
            DB::rollBack();
            return dd($exception);
        }
        return true;
    }

    public function deleteFromShoppingCartMakeshift(int $trackid)
    {
        $user = Auth::user();
        $username = $user->name;

        shoppingCart::where('username', '=', $username)->where('trackid', '=', $trackid)->delete();


        return redirect()->action('HomeController@displayShoppingCart');
    }

    /**
     * Buys all the tracks
     *
     * @return RedirectResponse
     */
    public function buyAll()
    {
        $user = Auth::user();
        $username = $user->name;

        $mongoUser = shoppingCart::where('username', '=', $username)->get();

        foreach ($mongoUser as $info) {
            $trackId = $info->trackid;
            $this->buyTrack($trackId);
            $this->deleteFromShoppingCartMakeshift($trackId);
        }
        return redirect()->action('HomeController@displayShoppingCart');
    }

    /**
     * Generates the changelog
     *
     * @return Application|Factory|View
     */
    public function changelog()
    {
        $user = Auth::user();

        $username = $user->name;


        $userQuery = DB::table('users')
            ->join('roles_relations', 'users.id', '=', 'roles_relations.id_user')
            ->where('users.name', $username)->first();
        $userRole = $userQuery->id_roles;
        if ($userRole != 1) {
            return view('Error405');
        } else {
            $changes = DB::select(DB::raw('SELECT * FROM bitacora'));


            return view('changelog', compact('changes'));
        }
    }

    /**
     * Generate a view for the shopping cart
     *
     * @return Application|Factory|View
     */
    public function displayShoppingCart()
    {
        $user = Auth::user();
        $username = $user->name;

        $mongoUser = shoppingCart::where('username', '=', $username)->get();

        return view('shoppingCart', compact('mongoUser'));

    }

    /**
     * Delete from the shopping cart
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteFromShoppingCart(Request $request)
    {
        $user = Auth::user();
        $username = $user->name;

        $trackid = $request->trackid;
        $trackid = (int)$trackid;

        shoppingCart::where('username', '=', $username)->where('trackid', '=', $trackid)->delete();


        return redirect()->action('HomeController@displayShoppingCart');

    }

    /**
     * Returns the view and allows the user to search for something
     *
     * @param int    $searcher Announces if something is being searched for or not
     * @param string $word     Word to be searched
     * @return Application|Factory|View
     */
    public function searchQuery($searcher = 1, $word = '')
    {

        $artists = DB::table('artist')->get();
        $albums = DB::table('album')
            ->join('artist', 'album.artistid', '=', 'artist.artistid')
            ->selectRaw(DB::raw('artist.name as artist, album.title as title, album.albumid as id'))
            ->get();
        $tracks = DB::table('track')
            ->join('album', 'track.albumid', '=', 'album.albumid')
            ->join('artist', 'album.artistid', '=', 'artist.artistid')
            ->join('mediatype', 'track.mediatypeid', '=', 'mediatype.mediatypeid')
            ->join('genre', 'track.genreid', '=', 'genre.genreid')
//            ->join('users', 'track.added_by', '=', 'users.id')
            ->selectRaw(DB::raw('track.trackid as trackid, track.name as track, album.title as album, artist.name as artist, mediatype.name as media, genre.name as genre, track.composer as composer, track.milliseconds as duration, track.bytes as size, track.unitprice as price'))
            ->where('hidden_status', '!=', '1')
            ->get();


        return view('searchQuery', compact('artists', 'albums', 'tracks'));


    }


    public function simulateSales(Request $request)
    {


        $counter = 0;
        $hours = rand(0, 9);
        $minutes = rand(0, 9);
        $seconds = rand(0, 9);
        $year = $request->year;
        $month = $request->month;
        $day = $request->day;

        switch (strtoupper($month)) {
            case 'ENERO':
            case 'JANUARY':
                $month = 1;
                break;
            case 'FEBRERO':
            case 'FEBRUARY':
                $month = 2;
                break;
            case 'MARZO':
            case 'MARCH':
                $month = 3;
                break;
            case 'ABRIL':
            case 'APRIL':
                $month = 4;
                break;
            case 'MAYO':
            case 'MAY':
                $month = 5;
                break;
            case 'JUNIO':
            case 'JUNE':
                $month = 6;
                break;
            case 'JULIO':
            case 'JULY':
                $month = 7;
                break;
            case 'AGOSTO':
            case 'AUGUST':
                $month = 8;
                break;
            case 'SEPTIEMBRE':
            case 'SEPTEMBER':
                $month = 9;
                break;
            case 'OCTUBRE':
            case 'OCTOBER':
                $month = 10;
                break;
            case 'NOVIEMBRE':
            case 'NOVEMBER':
                $month = 11;
                break;
            case 'DICIEMBRE':
            case 'DECEMBER':
                $month = 12;
                break;
        }


        $date = $year . '-' . $month . '-' . $day . ' ' . '0' . $hours . ':0' . $minutes . ':0' . $seconds;
        while ($counter < $request->iterations) {
            try {
                DB::beginTransaction();
                $id = rand(1, 1000);
                $userCount = DB::table('users')->count();
                $user_id = rand(1, $userCount);
                $trackCount = DB::table('track')->count();
                $idtrack = rand(1, $trackCount);
                $track = DB::table('track')->where('trackid', '=', $idtrack)->first();

                $location = DB::table('randomlocations')->where('locationid', '=', $id)->first();
                $invoice_table = new invoice();
                $invoiceline_table = new invoiceline();
                $invoiceid = DB::table('invoice')
                    ->orderBy('invoiceid', 'desc')
                    ->first();
                $idinvoice = $invoiceid->invoiceid;
                $invoice_table->invoiceid = $idinvoice + 1;
                $invoice_table->customerid = $user_id;
                $invoice_table->billingaddress = $location->billingaddress;
                $invoice_table->billingcity = $location->billingcity;
                $invoice_table->billingstate = $location->billingstate;
                $invoice_table->billingcountry = $location->billingcountry;
                $invoice_table->billingpostalcode = $location->billingpostalcode;
                $invoice_table->invoicedate = $date;
                $invoice_table->total = $track->unitprice;
                $invoice_table->save();// Insert into InvoiceLine Table
                $invoicelineid = DB::table('invoiceline')
                    ->orderBy('invoicelineid', 'desc')
                    ->first();
                $idinvoiceline = $invoicelineid->invoicelineid;
                $invoiceline_table->invoicelineid = $idinvoiceline + 1;
                $invoiceline_table->invoiceid = $idinvoice + 1;
                $invoiceline_table->trackid = $idtrack;
                $invoiceline_table->unitprice = (float)$track->unitprice;
                $invoiceline_table->quantity = 1;
                $invoiceline_table->save();

                // Reproduction Side
                $user_id = rand(1, $userCount);
                $idtrack = rand(1, $trackCount);

                $reproducedTable = new reproductions();

                $reproducedTable->trackid = $idtrack;
                $reproducedTable->userid = $user_id;
                $reproducedTable->reproduceddate = $date;
                $reproducedTable->save();

                $counter++;
                DB::commit();
            } catch (QueryException $e) {
                DB::rollBack();
                return $e;
            }
        }
        return redirect()->action('HomeController@profile');
    }

    public function reproduce(Request $request)
    {
        $user = Auth::user();
        $username = $user->id;


        $reproducedTable = new reproductions();
        $link = DB::table('track')->where('trackid', '=', $request->playButton)
            ->first();
        try {
            DB::beginTransaction();
            $reproducedTable->trackid = $request->playButton;
            $reproducedTable->userid = $username;
            $reproducedTable->save();
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            return $e;
        }

        return redirect($link->url);
    }

    public function displayAdminContent(Request $request)
    {
        $request_type = $request->select_category;


        if ($request_type == 'total_sales') {
            $dateOne = $request->fd;
            $dateTwo = $request->sd;
            $data_type = 1;

            $find_sales = DB::select('SELECT * FROM showData(?, ?)', array($dateOne, $dateTwo));
            if ($find_sales != null) {
                return view('adminStats', compact('find_sales', 'data_type', 'dateOne', 'dateTwo'));
            } else {
                return redirect('/adminStats');
            }

        } else if ($request_type == 'artists_number') {
            $dateOne = $request->fd;
            $dateTwo = $request->sd;
            $limiter = (int)$request->limiter;
            $data_type = 2;

            $find_artist = DB::select('SELECT * FROM bestArtists(?, ?, ?)', array($dateOne, $dateTwo, $limiter));

            if ($find_artist != null) {
                return view('adminStats', compact('find_artist', 'data_type', 'dateOne', 'dateTwo', 'limiter'));
            } else {
                return redirect('/adminStats');
            }
        } else if ($request_type == 'genre_total') {
            $dateOne = $request->fd;
            $dateTwo = $request->sd;
            $data_type = 3;

            $find_genre = DB::select('SELECT * FROM bestGenres(?, ?)', array($dateOne, $dateTwo));

            if ($find_genre != null) {
                return view('adminStats', compact('find_genre', 'data_type', 'dateOne', 'dateTwo'));
            } else {
                return redirect('/adminStats');
            }
        } else if ($request_type == 'tracks_by_artist') {
            $artistName = $request->fd;
            $limiter = (int)$request->sd;
            $data_type = 4;

            $queue_artist = DB::select('SELECT * FROM bestTracks(?, ?)', array($artistName, $limiter));
            if ($queue_artist != null) {
                return view('adminStats', compact('queue_artist', 'data_type', 'artistName', 'limiter'));
            } else {
                return redirect('/adminStats');
            }

        } else if ($request_type == 'empty') {
            return redirect('/adminStats');
        }
        return redirect('/adminStats');
    }


}

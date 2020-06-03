<?php

namespace App\Http\Controllers;

use App;
use App\shoppingCart;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PDFController extends Controller
{
    /**
     * Generates a new PDF Stream
     *
     * @param $mongoSaver
     * @return mixed
     */
    function pdf($mongoSaver)
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_to_pdf($mongoSaver));

        return $pdf->stream();
    }

    /**
     * Creates a PDF Info
     *
     * @param $mongoSaver
     * @return string
     */
    public function convert_to_pdf($mongoSaver)
    {
        $sum = 0.0;

        $mongoUser = $mongoSaver;
        $output = '
        <style>
        #invoicedate {
            width: 100%;
            text-align: center;
        }

        p {
        width: 100vw;
        color: white;
        background-color: #3b3a3b;
        padding: 30px;
        }

        #total {
        font-size: xx-large;
        position: fixed;
        bottom: 0;
        right: 0;
        text-align: right;
        text-decoration: underline;
        }
</style>
        <p>
        Spectrum Xplorer<br />
        This invoice has been auto-generated as<br />
        part of a necessary procedure<br/>
        Invoice date:
</p>
        <h3 id="invoicedate">' . Carbon::now() . '</h3>
        <h3 align="center">Track Invoice</h3>
        <table width="100%" style="border-collapse: collapse; border: 0px;">
        <tr>
        <th style="border: 1px solid black; padding: 12px;" width="20%">Artist</th>
        <th style="border: 1px solid black; padding: 12px;" width="30%">Album</th>
        <th style="border: 1px solid black; padding: 12px;" width="20%">Track</th>
        <th style="border: 1px solid black; padding: 12px;" width="20%">Price</th>
</tr>
        ';
        foreach ($mongoUser as $sale) {
            $sum += $sale->price;
            $output .= '
            <tr>
            <td style="text-align: center" >' . $sale->artist . '</td>
            <td style="text-align: center">' . $sale->album . '</td>
            <td style="text-align: center">' . $sale->track . '</td>
            <td style="text-align: center">$' . $sale->price . '</td>
</tr>
            ';
        }
        $output .= '</table>
<div id="total" >Total: $' . $sum . '</div>
';
        return $output;
    }

    public function get_sale_data($mongoSaver)
    {

        return $mongoSaver;
    }
}

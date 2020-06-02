<?php

namespace App\Http\Controllers;

use App;
use App\shoppingCart;
use Illuminate\Support\Facades\Auth;

class PDFController extends Controller
{
    function pdf($mongoSaver)
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_to_pdf($mongoSaver));

        return $pdf->stream();
    }

    public function convert_to_pdf($mongoSaver)
    {
        $sum = 0.0;

        $mongoUser = $mongoSaver;
        $output = '
        <h3 align="center">Invoice</h3>
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
            <td style="text-align: center">' . $sale->price . '</td>
</tr>
            ';
        }
        $output .= '</table>
<div id="total" style="position: fixed; bottom: 0">Total: ' . $sum . '</div>
';
        return $output;
    }

    public function get_sale_data($mongoSaver)
    {

        return $mongoSaver;
    }
}

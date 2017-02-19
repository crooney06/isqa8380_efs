@extends('app')
@section('content')
    <h1>Stock </h1>
    <div class="container">
        <table class="table table-striped table-bordered table-hover">
            <tbody>
            <tr class="bg-info">
            <tr>
                <td>Stock Symbol</td>
                <td><?php echo ($stock['symbol']); ?></td>
            </tr>
            <tr>
                <td>Stock Name</td>
                <td><?php echo ($stock['name']); ?></td>
            </tr>
            <tr>
                <td>Number of Shares</td>
                <td><?php echo ($stock['shares']); ?></td>
            </tr>
            <tr>
                <td>Purchase Price </td>
                <td><?php echo ($stock['purchase_price']); ?></td>
            </tr>
            <tr>
                <td>Date Purchased</td>
                <td><?php echo ($stock['purchased']); ?></td>
            </tr>
            <tr>
                <td>Current Price</td>
                <td>
                    <?php
                    $ssymbol = $stock->symbol;
                    //                        echo "<br><br>";

                    //                        print "Stock Symbol is:  $ssymbol";

                    $URL = "http://www.google.com/finance/info?q=NSE:" . $ssymbol;
                    $file = fopen("$URL", "r");
                    $r = "";
                    do {
                        $data = fread($file, 500);
                        $r .= $data;
                    } while (strlen($data) != 0);
                    //Remove CR's from ouput - make it one line
                    $json = str_replace("\n", "", $r);

                    //Remove //, [ and ] to build qualified string
                    $data = substr($json, 4, strlen($json) - 5);

                    //decode JSON data
                    $json_output = json_decode($data, true);
                    //echo $sstring, "<br>   ";
                    $price = "\n" . $json_output['l'];
                    //                        var_dump(json_decode($data));
                    //                        var_dump($price);
                    //echo "<br><br>";
                    //                        echo "Price in dollars delayed by 20 minutes $ ";
                                            echo $price;
                    //$stockprice=$price;


                    ?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <a href="{{url('/stocks')}}" class="btn btn-primary">Back to Stock List</a>
    <div><br></div>
@stop

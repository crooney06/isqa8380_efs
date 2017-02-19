@extends('app')
@section('content')
    <h1>Customer </h1>

    <div class="container">
        <table class="table table-striped table-bordered table-hover">
            <tbody>
            <tr class="bg-info">
            <tr>
                <td>Name</td>
                <td><?php echo ($customer['name']); ?></td>
            </tr>
            <tr>
                <td>Cust Number</td>
                <td><?php echo ($customer['cust_number']); ?></td>
            </tr>
            <tr>
                <td>Address</td>
                <td><?php echo ($customer['address']); ?></td>
            </tr>
            <tr>
                <td>City </td>
                <td><?php echo ($customer['city']); ?></td>
            </tr>
            <tr>
                <td>State</td>
                <td><?php echo ($customer['state']); ?></td>
            </tr>
            <tr>
                <td>Zip </td>
                <td><?php echo ($customer['zip']); ?></td>
            </tr>
            <tr>
                <td>Home Phone</td>
                <td><?php echo ($customer['home_phone']); ?></td>
            </tr>
            <tr>
                <td>Cell Phone</td>
                <td><?php echo ($customer['cell_phone']); ?></td>
            </tr>


            </tbody>
        </table>
    </div>


    <?php
    $stockprice=null;       //Purchase stock price placeholder
    $pstockvalue=null;      //Purchase stock price placeholder
    $cstockvalue=null;      //Current stock price placeholder
    $stotal = 0;            //Purchase stock value placeholder
    $svalue=0;              //Current stock value placeholder
    $itotal = 0;            //Purchase investments value placeholder
    $ivalue=0;              //Current investments value placeholder
    $iportfolio = 0;        //Initial portfolio value
    $cportfolio = 0;        //Current portfolio value
    ?>
    <br>
    <h2>Stocks </h2>
    <div class="container">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr class="bg-info">
                <th> Symbol </th>
                <th>Stock Name</th>
                <th>No. of Shares</th>
                <th>Purchase Price</th>
                <th>Purchase Date</th>
                <th>Original Value</th>
                <th>Current Price</th>
                <th>Current Value</th>
            </tr>
            </thead>

            <tbody>

            @foreach($customer->stocks as $stock)
                <tr>
                    <td>{{ $stock->symbol }}</td>
                    <td>{{ $stock->name }}</td>
                    <td align="right">{{ $stock->shares }}</td>
                    <td align="right">{{ number_format($stock->purchase_price,2) }}</td>
                    <td>{{ $stock->purchased }}</td>
                    <td align="right">
                        <?php
                        $pstockvalue=$stock->shares*$stock->purchase_price;
                        $stotal=$stotal+$pstockvalue;
                        ?>
                        {{ number_format($pstockvalue,2) }}
                    </td>
                    <td align="right">
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
//                        echo $price;
                        $stockprice=$price;


                        ?>
                    {{ number_format($stockprice,2) }}
                    </td>
                    <td align="right">
                        <?php
                            $cstockvalue=$stock->shares*$stockprice;
                            $svalue=$svalue+$cstockvalue;
                        ?>
                        {{ number_format($cstockvalue,2) }}
                    </td>

                </tr>


            @endforeach


            </tbody>
        </table>

        <p style="font-size:125%;">Total of Initial Stock Portfolio: ${{ number_format($stotal,2) }}</p>
        <p style="font-size:125%;">Total of Current Stock Portfolio: ${{ number_format($svalue,2) }}</p>
    </div>

    <br>
    <h2>Investments</h2>
    <div class="container">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr class="bg-info">
                <th>Category </th>
                <th>Description</th>
                <th>Acquired Value</th>
                <th>Acquired Date</th>
                <th>Recent Value</th>
                <th>Recent Date</th>
            </tr>
            </thead>

            <tbody>

            @foreach($customer->investments as $investment)
                <tr>
                    <td>{{ $investment->category }}</td>
                    <td>{{ $investment->description }}</td>
                    <td align="right">{{ number_format($investment->acquired_value,2) }}</td>
                    <td>{{ $investment->acquired_date }}</td>
                    <td align="right">{{ number_format($investment->recent_value,2) }}</td>
                    <td>{{ $investment->recent_date }}</td>

                </tr>

                <?php $itotal=$itotal+$investment->acquired_value ?>
                <?php $ivalue=$ivalue+$investment->recent_value ?>
            @endforeach

            </tbody>
        </table>

        <p style="font-size:125%;">Total of Initial Investment Portfolio: ${{ number_format($itotal,2) }}</p>
        <p style="font-size:125%;">Total of Current Investment Portfolio: ${{ number_format($ivalue,2) }}</p>

    </div>
    <br>

    <h2>Summary of Portfolio</h2>
    <?php
        $iportfolio=$stotal+$itotal;
        $cportfolio=$svalue+$ivalue;
    ?>
    <p style="font-size:125%;">Total of Initial Portfolio Value: ${{ number_format($iportfolio,2) }}</p>
    <p style="font-size:125%;">Total of Current Portfolio Value: ${{ number_format($cportfolio,2) }}</p>
<br>
    <a href="{{url('/customers')}}" class="btn btn-primary">Back to Customer List</a>
    <div><br></div>

@stop

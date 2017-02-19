@extends('app')
@section('content')
    <h1>Investment </h1>
    <div class="container">
        <table class="table table-striped table-bordered table-hover">
            <tbody>
            <tr class="bg-info">
            <tr>
                <td>Investment Category</td>
                <td><?php echo ($investment['category']); ?></td>
            </tr>
            <tr>
                <td>Investment Description</td>
                <td><?php echo ($investment['description']); ?></td>
            </tr>
            <tr>
                <td>Date Acquired</td>
                <td><?php echo ($investment['acquired_date']); ?></td>
            </tr>
            <tr>
                <td>Acquired Value</td>
                <td><?php echo ($investment['acquired_value']); ?></td>
            </tr>
            <tr>
                <td>Recent Date</td>
                <td><?php echo ($investment['recent_date']); ?></td>
            </tr>
            <tr>
                <td>Recent Value</td>
                <td><?php echo ($investment['recent_value']); ?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <a href="{{url('/investments')}}" class="btn btn-primary">Back to Investment List</a>
    <div><br></div>
@stop

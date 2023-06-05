@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">API Settings Informations</div>

                <div class="card-body">
               
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Api URL</th>
                            <th scope="col">Api Key</th>
                            <th scope="col">Status</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($apiData as $item)
                                
                            <?php 
                            if($item->status==1){ 
                                $statusMessage= "Active";
                            }else {
                                $statusMessage ='Not Active';
                            }

                            ?>
                         
                          <tr>
                            <th scope="row">{{ $item->name}}</th>
                            <td>{{ $item->api_url}}</td>
                            <td>{{ $item->api_key}}</td>
                            <td><?php echo $statusMessage ;?></td>
                          </tr>
                          @endforeach
                         
                        </tbody>
                      </table>
             
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users Informations</div>

                <div class="card-body">
               
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">View</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($userData as $item)
                                
                            <?php 
                            if($item->status==1){ 
                                $statusMessage= "Active";
                            }else {
                                $statusMessage ='Not Active';
                            }

                            ?>
                         
                          <tr>
                            <th scope="row">{{ $item->id}}</th>
                            <td>{{ $item->name}}</td>
                            <td>{{ $item->email}}</td>
                            <td><a href="<?php echo url('/user-view') .'/'.$item->id ; ?>" class="btn btn-success">View</a></td>
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

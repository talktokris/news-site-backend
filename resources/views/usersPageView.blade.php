@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach ($userData as $item)
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
                          </tr>
                          @endforeach
                         
                        </tbody>
                      </table>
             
                </div>
            </div>
            <div class="card">
                <div class="card-header">Sources Setting Informations</div>

                <div class="card-body">
               
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Label</th>
                          </tr>
                        </thead>
                        <tbody>
                 
                            @foreach ($item->source as $a_item)
                              
                          <tr>
                            <th scope="row">{{ $a_item->id}}</th>
                            <td>{{ $a_item->name}}</td>
                            <td>{{ $a_item->label}}</td>
                          </tr>
                          @endforeach
                         
                        </tbody>
                      </table>
             
                </div>
            </div>

            <div class="card">
                <div class="card-header">Category Setting Informations</div>

                <div class="card-body">
               
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Label</th>
                          </tr>
                        </thead>
                        <tbody>
                 
                            @foreach ($item->category as $a_item)
                              
                          <tr>
                            <th scope="row">{{ $a_item->id}}</th>
                            <td>{{ $a_item->name}}</td>
                            <td>{{ $a_item->label}}</td>
                          </tr>
                          @endforeach
                         
                        </tbody>
                      </table>
             
                </div>
            </div>
            <div class="card">
                <div class="card-header">Author Setting Informations</div>

                <div class="card-body">
               
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Label</th>
                          </tr>
                        </thead>
                        <tbody>
                 
                            @foreach ($item->author as $a_item)
                              
                          <tr>
                            <th scope="row">{{ $a_item->id}}</th>
                            <td>{{ $a_item->name}}</td>
                            <td>{{ $a_item->label}}</td>
                          </tr>
                          @endforeach
                         
                        </tbody>
                      </table>
             
                </div>
            </div>
           
            @endforeach
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('content')
    <h2>Posts</h2>
    <button onclick="location.href='{{route('categories.create')}}'" type="button" class="btn btn-secondary">Create</button>
    <br>
    <br>
    <table class="table">

            @foreach($categories as $category)
            <tr>
                <td>
                    <a href="{{route('categories.show',$category)}}">
                        <div class="category">{{$category->name}}</div> <p>{{$category->description}}</p>
                    </a>
                </td>
                <td>
                <td>
                    <button onclick="location.href='{{route('categories.edit',$category)}}'" type="button" class="btn btn-secondary">Edit</button>
                    <br>
                    <br>
                    <button onclick="location.href='{{route('categories.show',$category)}}'" type="button" class="btn btn-secondary">More</button>
                </td>
                </td>
            </tr>
            @endforeach

    </table>
    <ul class="pagination pull-left">
        {{$categories->links()}}
    </ul>
@endsection
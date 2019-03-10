@extends('layouts.app')
@section('content')
    <h2>Categories</h2>
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
                    <a href='{{route('categories.edit',$category)}}' name="edit-{{$category->id}}" type="button" class="btn btn-secondary" id="edit-{{$category->id}}"  >Edit</a>
                    <a onclick="" name="del{{$category->id}}" type="button" class="btn btn-secondary delete" id="{{$category->id}}" >Delete</a>
                    <a href='{{route('categories.show',$category)}}' type="button" class="btn btn-secondary" id="posts-{{$category->id}}"  >Posts</a>
                </td>
                </td>
            </tr>
            @endforeach

    </table>
    <ul class="pagination pull-left">
        {{$categories->links()}}
    </ul>

@endsection
@section('smt')
    <script>

        $(function() {

            $('.delete').on('click',function(){


                var category_id = $(this).attr('id');
                var token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({

                    type:'POST',
                    url:"{{ route('categories.destroy') }}",
                    dataType: 'JSON',
                    data: {
                        "_method": 'POST',
                        "_token": token,
                        "category_id":category_id
                    },
                    headers: {

                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')

                    },
                    success:function(data){
                        console.log(JSON.parse(data));
                        $('.table').load(location.href+' .table>*','');

                    },
                    error: function(err)
                    {
                        alert('fail');
                    },
                });




            });

        })

    </script>
    @endsection
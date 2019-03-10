@extends('layouts.app')
@section('content')
    <h2>{{$category->name}}</h2>
    <a href='{{route('posts.create',[$category])}}' type="button" class="btn btn-secondary">Create a new post</a>
    <br>
    <br>
    @foreach($posts as $post)
        <div class="post" href="">
            <div class="name">
                <a href="{{route('posts.create',[$category])}}">{{$post->name}}</a>
            </div>

            <div class="file">
                @isset ($post->file)
                    <img class="image" src="{{asset('/storage/'.$post->file)}}">
                @endisset
            </div>
            <div class="created_at">
                {{$post->created_at}}
            </div>
            <br>
            <button onclick="location.href='{{route('posts.show',[$category,$post])}}'" type="button" class="btn btn-secondary">More</button>
        </div>
    @endforeach
    @foreach($comments as $comment)
        <div class="comment">
            <div class="author">
                <?php echo mb_convert_case($comment->author, MB_CASE_TITLE, "UTF-8")  ?>
            </div>
            <div class="created_at">
                {{$comment->created_at}}
            </div>
            <div class="content">
                {{$comment->content}}
            </div>
        </div>
        @endforeach
<div class="aaa"></div>


    <div class="add-comment">
        <h3>Add a new comment</h3>
        {!! form($form) !!}
    </div>


@endsection
@section('smt')
<script>

    $(function() {

        $('#save').on('click',function(){


            var author = $('#author').val();
            var contentt = $('#contentt').val();
            var category_id = $('#category_id').val();
            var token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({

                type:'POST',
                url:"{{ route('commentcategory.store') }}",
                dataType: 'JSON',
                data: {
                    "_method": 'POST',
                    "_token": token,
                    "author":author,
                    "contentt":contentt,
                    "category_id":category_id
                },
                headers: {

                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')

                },
                success:function(data){
                    var el1 = $(".add-comment");
                    console.log(el1);
                    el1.before($('<div class="comment">\n' +
                        '            <div class="author">\n' +
                                        data.data.author+'\n' +
                        '            </div>\n' +
                        '            <div class="created_at">\n' +
                                        data.data.created_at+'\n' +
                        '            </div>\n' +
                        '            <div class="content">\n' +
                                        data.data.content+'\n' +
                        '            </div>\n' +
                        '        </div>'));
                    $('#author').val('');
                    $('#contentt').val('');

                },
                error: function(err)
                {
                    if (err.status == 422) { // when status code is 422, it's a validation issue
                        console.log(err.responseJSON);


                        // you can loop through the errors object and show it to the user
                        console.warn(err.responseJSON.errors);
                        // display errors on each form field
                        $.each(err.responseJSON.errors, function (i, error) {
                            var el = $(document).find('[name="'+i+'"]');
                             if($("#1"+i).length){
                                 console.log($('#1'+i));
                            }else{
                                 el.after($('<span id=1'+i+' style="color: red;">' + error[0] + '</span>'));

                             }
                        });
                    }
                },
            });


        });

    })

</script>
    @endsection
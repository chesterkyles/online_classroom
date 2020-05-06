@section('scripts')
    <script>
        $(document).ready(function () {
            $('form a').click(function() {
                $('input[name="'+$(this).attr('name') +'"]').click();
            });

            $('a.viewMore').click(function() {
                let items = $('ul#' + $(this).attr('id') + 'List > li:hidden');
                let pre_show = ($(this).attr('id').indexOf('post') >= 0) ? 10 : 2;
                if(items.length > 0) {
                    items.slice(0,pre_show).show();
                    if (items.length < (pre_show + 1)) $(this).html("");
                } else {
                    $(this).html("");
                }
                return false;
            });
            $('a.viewMore').click();

            // AJAX JQUERY
            $('a[name^="like"]').click(function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let $url = ($(this).attr('name') == 'like-post') ?
                        "{{ route('classroom.likePost', compact('subject')) }}" :           // Like Posts
                        "{{ route('classroom.likeComment', compact('subject', 'post')) }}"; // Like Comments
                $text = parseInt(e.target.nextElementSibling.innerHTML, 10);
                if(e.target.innerHTML.trim() == 'Like') {
                    $(e.target).html('Unlike');
                    $(e.target.nextElementSibling).html(($text) ? ($text + 1).toString() : '1');
                    $(e.target.nextElementSibling).addClass('mx-1 px-1 small rounded-circle bg-info text-light');
                } else {
                    $(e.target).html('Like');
                    if ($text == '1') {
                        $(e.target.nextElementSibling).html("");
                        $(e.target.nextElementSibling).removeClass('mx-1 px-1 small rounded-circle bg-info text-light');
                    } else
                        $(e.target.nextElementSibling).html(($text - 1).toString());
                }
                $.ajax({
                    url: $url,
                    method: "GET",
                    dataType: "json",
                    data: {id: id},
                    success:function (data) {
                        //nothing to do;
                    },
                    fail:function() {
                        alert('Problem with internet connection! Please refresh page');
                    }
                });
            });

        });
    </script>
@endsection

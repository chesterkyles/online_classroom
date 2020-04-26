<script src="https://cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/katex.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    $(document).ready(function() {
        var quill = new Quill('#editor-container', {
            modules: {
                toolbar: '#toolbar'
            },
            placeholder: 'Write your question here...',
            theme: 'snow'
        });
        quill.root.innerHTML = $('#editor-content').val();

        var $tab_id = '#single';
        $('#questionTypeSelect').on('change', function (e) {
            let $tab = $('#questionTypeOption li a').eq($(this).val());
            $tab.tab('show');
            $tab_id = $tab.attr('href');
        });

        function errorMessage(e) {
            e.preventDefault();
            $('#provide_answer').modal('show');
            return false;
        }

        $(this).on("submit", "form", function(e){
            $('#editor-content').val(quill.root.innerHTML);
            if ($tab_id === '#single') {
                if (!$($tab_id).find('input').val().trim()) {
                    errorMessage(e);
                }
            } else {
                if (typeof($($tab_id).find('input:checked').val()) === "undefined") {
                    errorMessage(e);
                }
            }

            var $input_points = $('input[name="question[points]"]');
            $($input_points).removeClass("is-invalid");
            if(!$input_points.val().trim()) {
                $($input_points).addClass("is-invalid");
                $($input_points).focus();
                e.preventDefault();
                return false;
            }
        });

    });
</script>

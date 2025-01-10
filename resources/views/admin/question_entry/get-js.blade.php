<script>
    $(document).ready(function() {
        // $('#exam_id').select2({
        //     width: '100%',
        //     placeholder: 'Select...',
        //     allowClear: true,
        //     ajax: {
        //         url: window.location.origin + '/admin/select-2-ajax',
        //         dataType: 'json',
        //         delay: 250,
        //         cache: true,
        //         data: function(params) {
        //             return {
        //                 q: $.trim(params.term),
        //                 type: 'getExam',
        //             };
        //         },
        //         processResults: function(data) {
        //             return {
        //                 results: data
        //             };
        //         }
        //     }
        // });
        $('#rank_id').select2({
            width: '100%',
            placeholder: 'Type to search...',
            allowClear: true,
            ajax: {
                url: window.location.origin + '/admin/select-2-ajax',
                dataType: 'json',
                delay: 250,
                cache: true,
                data: function(params) {
                    return {
                        q: $.trim(params.term),
                        type: 'getRank',
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                }
            }
        });
        $('#subject_id').select2({
            width: '100%',
            placeholder: 'Select Rank First...',
            allowClear: true,
            ajax: {
                url: window.location.origin + '/admin/select-2-ajax',
                dataType: 'json',
                delay: 250,
                cache: true,
                data: function(params) {
                    let rankId = $('#rank_id').find(":selected").val();
                    return {
                        q: $.trim(params.term),
                        type: 'getSubjectByRank',
                        rank_id: rankId
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                }
            }
        });
        $('#only_subject_id').select2({
            width: '100%',
            placeholder: 'Select Exam First...',
            allowClear: true,
            ajax: {
                url: window.location.origin + '/admin/select-2-ajax',
                dataType: 'json',
                delay: 250,
                cache: true,
                data: function(params) {
                    return {
                        q: $.trim(params.term),
                        type: 'getSubject',
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                }
            }
        });
        
    })
</script>

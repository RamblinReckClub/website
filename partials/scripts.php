<script src="/js/jquery-3.2.1.min.js"></script>
<script src="/js/popper.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/utils.js"></script>
<script src="/js/moment.js"></script>
<script>
    $('#sign-out-button').on('click', function(event) {
        event.preventDefault();
        $.ajax({
            url: '/login/signOut',
            type: 'GET',
            success: function (result) {
                console.log(result);
                window.location.replace('/');
            },
            error: function (error) {
                console.log(error)
                window.location.replace('/');
            }
        });
    });
</script>
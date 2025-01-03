
<!DOCTYPE html>
<html>
<head>
    <!-- ...existing code... -->
</head>
<body>
    <!-- ...existing code... -->

    @if(session('refresh'))
        <script>
            setTimeout(function() {
                location.reload();
            }, 5000);
        </script>
    @endif

    <!-- ...existing code... -->
</body>
</html>
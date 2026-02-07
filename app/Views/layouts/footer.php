</div> <!-- page content -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(function () {
        const alerts = [
            document.getElementById('flashSuccess'),
            document.getElementById('flashError')
        ];

        alerts.forEach(function (alert) {
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        });
    }, 2000); // 2 seconds
});
</script>
</body>
</html>
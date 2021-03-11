<!-- フラッシュメッセージ -->
<script>
    // 成功時
    @if (session('msg_success'))
    $(function () {
        toastr.success('{{ session('msg_success') }}');
    });

    // 失敗時
    @elseif (session('msg_error'))
    $(function () {
        toastr.error('{{ session('msg_error') }}');
    });

    @endif
</script>

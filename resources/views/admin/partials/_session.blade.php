@if (session('success'))

    <script>
        new Noty({
            type: 'success',
            @if(app()->getLocale() == 'ar')
            layout: 'topLeft',
            @else
            layout: 'topRight',
            @endif
            text: "{{ session('success') }}",
            timeout: 2000,
            killer: true
        }).show();
    </script>

@elseif(session('error'))

        <script>
            new Noty({
                type: 'error',
                layout: 'topLeft',
                text: "{{ session('error') }}",
                timeout: 2000,
                killer: true
            }).show();
        </script>

@endif

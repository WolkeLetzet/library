<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
            @else
            <img src="{{ asset('img/quinterologo-01.png') }}" alt="Laravel Logo" style="height: 100%; width: 100% ; max-height: 300px">
            @endif
        </a>
    </td>
</tr>

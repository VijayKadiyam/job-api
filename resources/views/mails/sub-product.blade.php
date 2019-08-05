<style type="text/css">
  table, tr, td {
    border: 1px solid black;
    border-collapse: collapse;
  }
</style>

{!! $subProduct->email_html !!}

<br>
<br>
Regards,
<br>
{{ $user->name }}
<br>
{{ $user->email }}
<br>
Phone: {{ $user->phone }}
<br>
Address: {{ $user->address }}
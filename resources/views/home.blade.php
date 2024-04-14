@include("parts.header")
@if($users)
    <ul>
        @foreach($users as $user)
            <li>{{ $user->email }} {{ $user->meno }}
            <a href="{{ route('delete', ['id' => $user->id]) }}">DELETE</a> </li>
        @endforeach
    </ul>
@else
    <b>Users not found</b>
@endif
@include("parts.footer")

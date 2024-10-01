@extends('Layout')
@section('content')
    <table>
        <caption>User List</caption>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Timezone</th>
                <th>Hobbies</th>
                <th>Matches</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $key => $user)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->timezone }}</td>
                    <td>
                        @if ($user->hobbies->count() > 0)
                            {{ implode(', ', $user->hobbies->pluck('hobbies')->toArray()) }}
                        @else
                            No hobbies listed
                        @endif
                    </td>
                    <td>
                        @if (count($user->matching_users) > 0)
                            {{ implode(', ', $user->matching_users) }}
                        @else
                            No matching users
                        @endif
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection

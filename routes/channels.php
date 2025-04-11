Broadcast::channel('customer.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

gj-user-approve
===
A way to flag users when registering for a WordPress site into a pending status. That status can then be marked manually by an admin as approved or denied. 

## install
Add as a WordPress plugin by downloading the zip file or include as a submodule.

## usage

During the registration process of a new user declare this function to append the status of 'Pending' to a new user account.

```
update_user_meta($user_id, 'approval_status', 'Pending');
```

To verify a user is approved for a section of the site use the `get_user_meta` function provided by WordPress.

```
if(get_user_meta($user_id, 'approval_status', true) === 'Approved') {
    //do stuff
}
```

Possible options include 'Approved', 'Pending', or 'Denied'.

### mailgun

The plugin support mailgun and allows it to be configured through the admin panel of GJ User Approve.

## todo
- email notification of approval state
- build into registration?

## license

MIT
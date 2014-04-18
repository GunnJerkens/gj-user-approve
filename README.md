gj-user-approve
===
A way to flag users when registering for a WordPress site into a pending status. That status can then be marked manually by an admin as approved or denied. 

## install
Add as a WordPress plugin by downloading the zip file or include as a submodule.

## usage

During the registration process of a new user declare this function to append the status of 'Pending' to a new user account.

`update_user_meta( $user_id, 'approval_status', 'Pending' );`

## todo
- create a simple function to add user_meta field 'pending'
- create a quick boolean function for a double auth check
- email notification of approval state

## license

MIT
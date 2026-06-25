# Transaction Cancellation

You are a senior software engineer with 8 years experience trying to maintain a legacy code with keeping the coding style. You need to add a new feature of "Transaction Cancellation"

An admin can cancel an order transaction, so the `trnsactions.payment_status` become `CANCELLED` and the quantity restored back as much as the record has. The system already have form validation in the registration flow that the user's credentials like `email` and `nik` could not be used again (for complete column you should check the code). Then if the transaction has been cancelled, this credential can be used again.

Put the cancel button in the existing context menu. Add confirmation before cancelling the transaction. Send a notification to the related user to inform that their transaction was cancelled.

Make sure it has no conflict of the quantity, no race condition, or any common issues that can be happened.
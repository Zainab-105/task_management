<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Task Assigned to You</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <div style="background-color: #fff; border-radius: 5px; padding: 20px;">
        <h2 style="color: #333;">Task Assigned Notification</h2>
        <p style="color: #333;">Hello {{ $task->user->name }},</p>
        <p style="color: #333;">A new task has been assigned to you:</p>
        <p style="color: #333; margin-bottom: 0;"><strong>Task Name:</strong> {{ $task->title }}</p>
        <p style="color: #333;"><strong>Due Date:</strong> {{ $task->due_date }}</p>
        <p style="color: #333;">Please log in to your account to view the details and complete the task.</p>
        <p style="color: #333;">Best regards,<br>Task Management</p>
    </div>

</body>
</html>

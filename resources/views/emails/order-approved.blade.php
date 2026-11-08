<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;">

    <div style="background-color: #1E3A5F; padding: 30px; text-align: center;">
        <h1 style="color: #FFBF00; margin: 0; font-size: 24px;">Payment Confirmed!</h1>
    </div>

    <div style="padding: 30px; background-color: #ffffff; color: #333333; line-height: 1.6;">
        <p style="font-size: 16px;">Hello <strong>{{ $order->user->name }}</strong>,</p>

        <p style="font-size: 16px;">Great news! We have successfully verified your payment receipt for <strong>Order #{{ $order->order_id }}</strong>.</p>

        <div style="background-color: #f8fafc; border-left: 4px solid #1E3A5F; padding: 15px; margin: 20px 0;">
            <p style="margin: 0; font-weight: bold; color: #1E3A5F;">What happens next?</p>
            <p style="margin: 5px 0 0 0; font-size: 14px;">Our team is now preparing your new laptop for dispatch. You will receive another update as soon as it is handed over to our delivery partners.</p>
        </div>

        <p style="font-size: 16px;">Thank you for choosing Khit PC. We can't wait for you to experience your new machine!</p>

        <br>
        <p style="margin: 0; color: #64748b; font-size: 14px;">Best regards,</p>
        <p style="margin: 0; font-weight: bold; color: #1E3A5F;">The Khit PC Team</p>
    </div>
</div>

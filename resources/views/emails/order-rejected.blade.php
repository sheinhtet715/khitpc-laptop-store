<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;">

    <div style="background-color: #D32F2F; padding: 30px; text-align: center;">
        <h1 style="color: #ffffff; margin: 0; font-size: 24px;">Payment Verification Failed</h1>
    </div>

    <div style="padding: 30px; background-color: #ffffff; color: #333333; line-height: 1.6;">
        <p style="font-size: 16px;">Hello <strong>{{ $order->user->name }}</strong>,</p>

        <p style="font-size: 16px;">We encountered an issue while verifying the payment receipt for your laptop purchase (<strong>Order #{{ $order->order_id }}</strong>).</p>

        @if($note)
            <div style="background-color: #fff1f2; border-left: 4px solid #D32F2F; padding: 15px; margin: 20px 0;">
                <p style="margin: 0; font-weight: bold; color: #D32F2F;">Admin Note:</p>
                <p style="margin: 5px 0 0 0; font-size: 15px;">"{{ $note }}"</p>
            </div>
        @endif

        <p style="font-size: 16px;">To ensure your order is not cancelled, please log back into your Khit PC account and upload a clear, valid payment receipt.</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/user/home') }}" style="background-color: #1E3A5F; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;">View Your Orders</a>
        </div>

        <br>
        <p style="margin: 0; color: #64748b; font-size: 14px;">Best regards,</p>
        <p style="margin: 0; font-weight: bold; color: #1E3A5F;">The Khit PC Team</p>
    </div>
</div>

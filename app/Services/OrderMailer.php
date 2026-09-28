<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

/**
 * Sends order notification emails to the customer and the administrator.
 *
 * Delivery uses PHP's built-in mail() function directly — no third-party
 * service, SMTP account or external package is involved. On any standard
 * PHP host (cPanel, shared hosting, VPS with sendmail/postfix) this works
 * out of the box.
 */
class OrderMailer
{
    /**
     * Notify customer + admin that a new order has been placed.
     *
     * @param  \App\Models\Order $order
     * @return void
     */
    public function orderPlaced(Order $order)
    {
        $order->load('orderItems');

        $customerHtml = View::make('emails.order-placed', array(
            'order'    => $order,
            'forAdmin' => false,
        ))->render();

        $adminHtml = View::make('emails.order-placed', array(
            'order'    => $order,
            'forAdmin' => true,
        ))->render();

        $this->send(
            $order->shipping_email,
            'Your Ananya order ' . $order->order_number . ' is confirmed',
            $customerHtml
        );

        $this->send(
            config('store.admin_email'),
            'New order ' . $order->order_number . ' — ' . config('store.currency') . ' ' . number_format($order->total, 2),
            $adminHtml
        );
    }

    /**
     * Notify customer + admin that an order's status has changed.
     *
     * @param  \App\Models\Order $order
     * @param  string            $previousStatus
     * @param  string|null       $note
     * @return void
     */
    public function statusChanged(Order $order, $previousStatus, $note = null)
    {
        $order->load('orderItems');

        $customerHtml = View::make('emails.order-status', array(
            'order'          => $order,
            'previousStatus' => $previousStatus,
            'note'           => $note,
            'forAdmin'       => false,
        ))->render();

        $adminHtml = View::make('emails.order-status', array(
            'order'          => $order,
            'previousStatus' => $previousStatus,
            'note'           => $note,
            'forAdmin'       => true,
        ))->render();

        $this->send(
            $order->shipping_email,
            'Your Ananya order ' . $order->order_number . ' is now ' . ucfirst($order->status),
            $customerHtml
        );

        $this->send(
            config('store.admin_email'),
            'Order ' . $order->order_number . ': ' . ucfirst($previousStatus) . ' -> ' . ucfirst($order->status),
            $adminHtml
        );
    }

    /**
     * Low-level send via native PHP mail(). Failures are logged, never thrown,
     * so a mail issue can never break checkout or the admin panel.
     *
     * @param  string|null $to
     * @param  string      $subject
     * @param  string      $html
     * @return void
     */
    protected function send($to, $subject, $html)
    {
        if (empty($to)) {
            return;
        }

        $fromEmail = config('store.mail_from');
        $fromName  = config('store.mail_from_name');

        $headers = array(
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . $this->encodeName($fromName) . ' <' . $fromEmail . '>',
            'Reply-To: ' . $fromEmail,
            'X-Mailer: PHP/' . phpversion(),
        );

        $subjectEncoded = '=?UTF-8?B?' . base64_encode($subject) . '?=';

        try {
            $ok = @mail($to, $subjectEncoded, $html, implode("\r\n", $headers));

            if (! $ok) {
                Log::warning('OrderMailer: mail() returned false for ' . $to . ' (' . $subject . ')');
            }
        } catch (\Exception $e) {
            // PHP 5.6 has no \Throwable; \Exception covers everything mail() can raise.
            Log::error('OrderMailer: mail() threw ' . $e->getMessage());
        }
    }

    /**
     * @param  string $name
     * @return string
     */
    protected function encodeName($name)
    {
        return '=?UTF-8?B?' . base64_encode($name) . '?=';
    }
}

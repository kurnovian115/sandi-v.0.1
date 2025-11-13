<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pengaduan;

class TicketCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengaduan;

    public function __construct(Pengaduan $pengaduan)
    {
        $this->pengaduan = $pengaduan;
    }

    public function build()
    {
        return $this->subject('Informasi Tiket Pengaduan: ' . $this->pengaduan->no_tiket)
                    ->view('emails.pengaduan.created_html')
                    ->with(['pengaduan' => $this->pengaduan]);
    }


}

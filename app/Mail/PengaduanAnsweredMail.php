<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pengaduan;

class PengaduanAnsweredMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengaduan;

    /**
     * Create a new message instance.
     *
     * @param Pengaduan $pengaduan
     */
    public function __construct(Pengaduan $pengaduan)
    {
        $this->pengaduan = $pengaduan;
    }

    public function build()
    {
        return $this->subject('Pembaharuan Pengaduan — ' . ($this->pengaduan->no_tiket ?? ''))
                    ->view('emails.pengaduan.answered')
                    ->with(['pengaduan' => $this->pengaduan]);
    }
}

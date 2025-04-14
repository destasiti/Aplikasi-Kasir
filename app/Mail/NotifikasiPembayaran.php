<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Penjualan;
use App\Models\Pembayaran;
use App\Models\Toko;

class NotifikasiPembayaran extends Mailable
{
        use Queueable, SerializesModels;
    
        public $penjualan;
        public $pembayaran;
        public $profileToko;
    
        public function __construct($penjualan, $pembayaran, $profileToko)
        {
            $this->penjualan = $penjualan;
            $this->pembayaran = $pembayaran;
            $this->profileToko = $profileToko;
        }
    
        public function build()
        {
            return $this->subject('Struk Pembayaran Anda - ' . $this->profileToko->NamaToko)
                        ->markdown('emails.notifikasi_pembayaran');
        }
    }
    
    

    /**
     * Create a new message instance.
    //  */
    // public function __construct(Penjualan $penjualan, Pembayaran $pembayaran)
    // {
    //     $this->penjualan = $penjualan;
    //     $this->pembayaran = $pembayaran;
    // }

    // /**
    //  * Build the message.
    //  */
    // public function build()
    // {
    //     return $this->subject('Konfirmasi Pembayaran Berhasil')
    //                 ->view('emails.notifikasi_pembayaran');
    // }


<x-mail::message>
# Halo {{ $booking->nama }},

Pembayaran Down Payment (DP) untuk perjalanan Anda telah kami terima dan berhasil **Dikonfirmasi**.

<x-mail::panel>
### Rincian Invoice DP:
- **Destinasi:** {{ $booking->destination->name }}
- **Tanggal Keberangkatan:** {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
- **Jumlah Peserta:** {{ $booking->jumlah_orang }} Pax
- **Total Biaya:** Rp {{ number_format($booking->total_price, 0, ',', '.') }}
- **DP Terbayar (30%):** Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}
- **Kekurangan Pelunasan (70%):** **Rp {{ number_format($booking->total_price - $booking->dp_amount, 0, ',', '.') }}**
</x-mail::panel>

Harap segera melunasi sisa kekurangan sebesar **Rp {{ number_format($booking->total_price - $booking->dp_amount, 0, ',', '.') }}** sebelum tanggal keberangkatan melalui halaman pemesanan Anda di website Travelingin.id.

Silakan bergabung ke grup koordinasi WhatsApp untuk berinteraksi dengan pemandu dan peserta lainnya melalui tautan di bawah ini:

<x-mail::button :url="$booking->destination->whatsapp_link ?? 'https://chat.whatsapp.com/travelingin-group'">
Gabung Grup WhatsApp
</x-mail::button>

Terima kasih,<br>
Tim Travelingin.id
</x-mail::message>

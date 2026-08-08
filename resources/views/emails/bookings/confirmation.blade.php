<x-mail::message>
# Halo {{ $booking->nama }},

Terima kasih telah melakukan pemesanan di **Travelingin.id**. Berikut adalah rincian pesanan Anda yang telah terverifikasi pembayarannya (Down Payment).

<x-mail::panel>
### Detail Pesanan:
- **Destinasi:** {{ $booking->destination->name }}
- **Tanggal Keberangkatan:** {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
- **Jumlah Orang:** {{ $booking->jumlah_orang }} Pax
- **Total Biaya:** Rp {{ number_format($booking->total_price, 0, ',', '.') }}
- **DP Terbayar:** Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}
</x-mail::panel>

Status pesanan Anda saat ini adalah **DP Terbayar (Lunas DP)**. Kami akan segera menghubungi Anda melalui nomor WhatsApp ({{ $booking->no_hp }}) untuk koordinasi keberangkatan lebih lanjut.

Harap simpan email ini sebagai bukti pemesanan Anda.

Terima kasih,<br>
Tim Travelingin.id
</x-mail::message>

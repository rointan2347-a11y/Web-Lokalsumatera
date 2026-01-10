@extends('depan.layouts.main')

@section('title', 'Keranjang')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold mb-4">Keranjang Saya</h2>

        @if (session('success'))
            <div class="alert alert-success" id="pesan-alert">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (count($items) > 0)
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Item</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Ukuran</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            @php
                                $isProduk = $item->produk !== null;
                                $isKustom = $item->kaosKustom !== null;

                                $nama = $isProduk ? $item->produk->nama : 'Kaos Kustom';
                                $harga = $isProduk
                                    ? $item->produk->harga_diskon ?? $item->produk->harga
                                    : $item->kaosKustom->harga; // Harga tetap atau dari field kaos_kustom
                                $subtotal = $harga * $item->jumlah;
                            @endphp
                            <tr>
                                <td>
                                    @if ($isProduk)
                                        {{ $item->produk->nama }}
                                    @elseif ($isKustom)
                                        <strong>Kaos Desain Sendiri</strong><br>
                                        <div class="d-flex mt-2 gap-2">
                                            <img src="{{ asset('storage/' . $item->kaosKustom->desain_depan) }}"
                                                alt="Depan" width="60">
                                            <img src="{{ asset('storage/' . $item->kaosKustom->desain_belakang) }}"
                                                alt="Belakang" width="60">
                                        </div>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($harga, 0, ',', '.') }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ $item->ukuran }}</td>
                                <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('checkout.form', $item->id) }}"
                                        class="btn btn-sm btn-outline-dark mb-2"><i class="bi bi-bag"></i> Checkout</a>
                                    <form action="{{ route('keranjang.hapus', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus item ini dari keranjang?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i>
                                            Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">Keranjang Anda masih kosong. <a href="/produk">Lihat Produk</a></div>
        @endif
    </div>
@endsection

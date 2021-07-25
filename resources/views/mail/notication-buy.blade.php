<body>
    <h3 style="color: #000">
        Xin chào {{ $name }}</h3>
    <p style="color: #000">
        Rất cảm ơn quý khách đã tin tưởng và lựa chọn sản phẩm tại cửa hàng E-Smart của chúng tôi
    </p>
    <h4 style="color: #000">Chi tiết đơn hàng</h4>

    <table class="table" style="border: black">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">TÊN SẢN PHẨM</th>
                <th scope="col">ĐƠN GIÁ</th>
                <th scope="col">SỐ LƯỢNG</th>
                <th scope="col">THÀNH TIỀN</th>
            </tr>
        </thead>
        <tbody>
            @php
            $temp = 1;
            @endphp
            @foreach ($body as $item)
                <tr>
                    <th scope="row">{{ $temp++ }}</th>
                    <td>{{ $item['infoProduct']['product_name'] }}</td>
                    <td>{{ number_format($item['infoProduct']['product_price'], '0', ',', '.') }}đ</td>
                    <td>{{ $item['qty'] }}</td>
                    <td>{{ number_format($item['infoProduct']['product_price'] * $item['qty'], '0', ',', '.') }}đ
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="font-weight: bold">
        <span>Tổng tiền: </span>
        <span style="color: red">{{ number_format($total, '0', ',', '.') }}</span>
    </div>

    <div>
        <h3 style="color: #000">Thông tin giao hàng</h3>
        <p style="color: #000">
            Họ tên : <strong>{{ $dataOrder['order_name'] }}</strong>
        </p>
        <p style="color: #000">
            Địa chỉ giao hàng : <strong>{{ $dataOrder['order_address'] }}</strong>
        </p>
        <p style="color: #000">
            Số điện thoại : <strong>{{ $dataOrder['order_phone'] }}</strong>
        </p>
        <p style="color: #000">
            Phương thức thanh toán :
            <strong>
                @if ($dataOrder['order_payment'] == 1)
                    <span>Thanh toán online</span>
                @else
                    <span>Thanh toán khi nhận hàng</span>
                @endif
            </strong>
        </p>
        @if ($dataOrder['order_payment'] == 2)
            <p style="color: silver">
                <span>Vui lòng chuẩn bị đầy đủ số tiền để thanh toán trước khi nhận hàng</span>
            </p>
        @endif
    </div>
</body>

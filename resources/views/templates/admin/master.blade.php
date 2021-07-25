<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin | E-Smart</title>
    <!-- plugins:css -->
    <base href="{{ asset('') }}">
    <link rel="stylesheet" href="templates/admin/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="templates/admin/vendors/css/vendor.bundle.base.css">

    <link rel="stylesheet" href="templates/admin/css/tab.css">

    <link rel="stylesheet" href="templates/admin/css/style.css">
    <link rel="icon" type="image/png" href="templates/esmart/images/iconlogo.png" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>

<body>

    <div class="container-scroller">
        <!-- Header -->
        @include('templates.admin.inc.header')
        <!-- /.End Header -->
        <div class="container-fluid page-body-wrapper">
            <!-- Sidebar -->
            @include('templates.admin.inc.sidebar')
            <!-- /.Sidebar -->
            <div class="main-panel">
                <!-- content-wrapper -->
                <div class="content-wrapper">
                    @yield('main-content')
                </div>
                <!-- /.Content-wrapper -->
                <!-- Footer -->
                @include('templates.admin.inc.footer')
                <!-- /.Footer -->
            </div>
        </div>
    </div>

    <!-- plugins:js -->
    <script src="templates/admin/vendors/js/vendor.bundle.base.js"></script>
    <script src="templates/admin/vendors/chart.js/Chart.min.js"></script>
    <script src="templates/admin/js/off-canvas.js"></script>
    <script src="templates/admin/js/hoverable-collapse.js"></script>
    <script src="templates/admin/js/misc.js"></script>
    <script src="templates/admin/js/dashboard.js"></script>
    <script src="templates/admin/js/todolist.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <!-- CSRF-TOKEN -->
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    </script>
    <!-- SUMMERNOTE -->
    <script type="text/javascript">
        $(document).ready(function() {
            // Define function to open filemanager window
            var lfm = function(options, cb) {
                var route_prefix = "{{ asset('') }}" + 'laravel-filemanager';
                window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager',
                    'width=900,height=600');
                window.SetUrl = cb;
            };
            // Define LFM summernote button
            var LFMButton = function(context) {
                var ui = $.summernote.ui;
                var button = ui.button({
                    contents: '<i class="note-icon-picture"></i> ',
                    tooltip: 'Insert image with filemanager',
                    click: function() {

                        lfm({
                            type: 'image',
                            prefix: '/laravel-filemanager'
                        }, function(lfmItems, path) {
                            lfmItems.forEach(function(lfmItem) {
                                context.invoke('insertImage', lfmItem.url);
                            });
                        });
                    }
                });
                return button.render();
            };
            // Initialize summernote with LFM button in the popover button group
            // Please note that you can add this button to any other button group you'd like
            $('.summernote').summernote({
                // placeholder: 'Hello stand alone ui',
                tabsize: 2,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                    ['popovers', ['lfm']],
                ],
                buttons: {
                    lfm: LFMButton
                },
            })
        });
        const tabs = document.querySelector(".wrapper");
        const tabButton = document.querySelectorAll(".tab-button");
        const contents = document.querySelectorAll(".content");

        tabs.onclick = e => {
          const id = e.target.dataset.id;
          if (id) {
            tabButton.forEach(btn => {
              btn.classList.remove("active");
            });
            e.target.classList.add("active");

            contents.forEach(content => {
              content.classList.remove("active");
            });
            const element = document.getElementById(id);
            element.classList.add("active");
          }
        };


    </script>
</body>

</html>

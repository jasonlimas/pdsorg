<div>
    <!-- Quote sender and receiver texts -->
    <h2 class="text-2xl font-medium">Attachment</h2>
    <p class="text-gray-600 mb-3">
        Add an attachment to the end of the quote.
    </p>

    <div>
        <!-- File uploader -->
        <input type="file" name="attachment" id="attachment">
    </div>

    @section('scripts')
        <script>
            const inputElement = document.querySelector('input[id="attachment"]');
            const pond = FilePond.create(inputElement);
            FilePond.setOptions({
                server: {
                    url: '/upload',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            });
        </script>
    @endsection
</div>

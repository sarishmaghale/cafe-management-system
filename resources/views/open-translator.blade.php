@extends('layout')

@push('styles')
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .translator-container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 900px;
            margin: 50px auto;
        }

        textarea {
            resize: none;
        }

        .translate-btn {
            border-radius: 50%;
            width: 60px;
            height: 60px;
            font-size: 24px;
        }

        .translate-btn:hover {
            background-color: #05224e;
            color: white;
        }
    </style>
@endpush

@section('content')
    <form id="translatorForm">
        @csrf
        <div class="translator-container">
            <h2 class="text-center mb-4 fw-bold text-primary">🌍 Language Translator</h2>
            <div class="row align-items-center">
                <!-- Input Box -->
                <div class="col-md-5">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">From</label>
                        <select id="sourceLang" class="form-select mb-2">
                            {{-- function defined in helpers.php --}}
                            @foreach (getLanguages() as $language)
                                <option value="{{ $language['code'] }}">{{ $language['name'] }}</option>
                            @endforeach
                        </select>
                        <textarea id="sourceText" rows="6" class="form-control border-primary" placeholder="Enter text..."></textarea>
                    </div>
                </div>

                <!-- Translate Button -->
                <button type="button" id="translateBtn" class="btn btn-outline-primary translate-btn shadow-sm">➜</button>

                <!-- Output Box -->
                <div class="col-md-5">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">To</label>
                        <select id="targetLang" class="form-select mb-2">
                            <option value="ko" selected>Korean</option>
                            {{-- function defined in helpers.php --}}
                            @foreach (getLanguages() as $language)
                                <option value="{{ $language['code'] }}">{{ $language['name'] }}</option>
                            @endforeach
                        </select>
                        <textarea id="translatedText" rows="6" class="form-control border-success bg-light" readonly
                            placeholder="Translation will appear here..."></textarea>
                    </div>
                </div>


            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.getElementById('translateBtn').addEventListener('click', function() {
            var form = document.getElementById('translatorForm');
            var token = form.querySelector('input[name="_token"]')
                .value; //required for laravel POSR/PUT/DELETE for csrf protection
            var text = document.getElementById('sourceText').value.trim();
            var to = document.getElementById('targetLang').value;
            var output = document.getElementById('translatedText');
            var from = document.getElementById('sourceLang').value;
            if (!text) {
                alert("Please enter text to translate.");
                return;
            }
            output.value = "Translating...";
            fetch("{{ route('translator.translate') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token
                    },
                    body: JSON.stringify({
                        text: text,
                        to: to,
                        from: from
                    })
                })
                .then(function(response) {
                    if (!response.ok) throw new Error(response
                        .status); //if response not ok, error thrown & jumps to catch
                    return response.json();
                })
                .then(function(data) {
                    output.value = data.translatedText
                })
                .catch(function(err) {
                    console.error(err);
                    output.value = "Error connecting to translation service.";
                });
        });
    </script>
@endpush

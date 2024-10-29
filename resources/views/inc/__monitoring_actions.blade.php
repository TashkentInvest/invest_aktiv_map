    <!-- Apz Yaratish Modal -->
    <div class="modal fade" id="createApzModal" tabindex="-1" aria-labelledby="createApzModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createApzModalLabel">Create Apz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('apz.store') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{$monitoring->id}}" name="shartnoma_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="ariza-raqami" class="form-label">Ariza Raqami</label>
                            <input type="text" class="form-control" id="ariza-raqami" name="ariza_raqami" required>
                        </div>

                        <!-- Ariza Sanasi Field -->
                        <div class="mb-3">
                            <label for="ariza-sanasi" class="form-label">Ariza Sanasi</label>
                            <input type="date" class="form-control" id="ariza-sanasi" name="ariza_sanasi" required>
                        </div>

                        <!-- Art Raqami Field -->
                        <div class="mb-3">
                            <label for="art-raqami" class="form-label">ART Raqami</label>
                            <input type="text" class="form-control" id="art-raqami" name="art_raqami" required>
                        </div>

                        <!-- Art Sanasi Field -->
                        <div class="mb-3">
                            <label for="art-sanasi" class="form-label">ART Sanasi</label>
                            <input type="date" class="form-control" id="art-sanasi" name="art_sanasi" required>
                        </div>
                        <div class="mb-3">
                            <label for="xulosa_izoh" class="form-label">Izoh</label>
                            <textarea name="xulosa_izoh" class="form-control" id="xulosa_izoh" cols="30" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Apz</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Kengash Yaratish Modal -->
    <div class="modal fade" id="createKengashModal" tabindex="-1" aria-labelledby="createKengashModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createKengashModalLabel">Create Kengash</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('kengash.store') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{$monitoring->id}}" name="shartnoma_id">

                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="kengash-ariza-raqami" class="form-label">Kengash Ariza Raqami</label>
                            <input type="text" class="form-control" id="kengash-ariza-raqami" name="ariza_raqami"
                                required>
                        </div>

                        <!-- Kengash Bayon Raqami Field -->
                        <div class="mb-3">
                            <label for="kengash-bayon-raqami" class="form-label">Kengash Bayon Raqami</label>
                            <input type="text" class="form-control" id="kengash-bayon-raqami" name="bayon_raqami"
                                required>
                        </div>

                        <!-- Kengash Bayon Sanasi Field -->
                        <div class="mb-3">
                            <label for="kengash-bayon-sanasi" class="form-label">Kengash Bayon Sanasi</label>
                            <input type="date" class="form-control" id="kengash-bayon-sanasi" name="bayon_sanasi"
                                required>
                        </div>

                        <!-- Kengash Bayon Izoh Field -->
                        <div class="mb-3">
                            <label for="kengash-bayon-izoh" class="form-label">Kengash Bayon Izoh</label>
                            <textarea name="bayon_izoh" class="form-control" id="kengash-bayon-izoh" cols="30" rows="3"></textarea>
                        </div>

                        <!-- Kengash Xulosa Raqami Field -->
                        <div class="mb-3">
                            <label for="kengash-raqami" class="form-label">Kengash Xulosa Raqami</label>
                            <input type="text" class="form-control" id="kengash-raqami" name="xulosa_raqami"
                                required>
                        </div>

                        <!-- Kengash Xulosa Sanasi Field -->
                        <div class="mb-3">
                            <label for="kengash-sanasi" class="form-label">Kengash Xulosa Sanasi</label>
                            <input type="date" class="form-control" id="kengash-sanasi" name="xulosa_sanasi"
                                required>
                        </div>

                        <!-- Kengash Xulosa Izoh Field -->
                        <div class="mb-3">
                            <label for="kengash-izoh" class="form-label">Izoh</label>
                            <textarea name="xulosa_izoh" class="form-control" id="kengash-izoh" cols="30" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Kengash</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Expertiza Yaratish Modal -->
    <div class="modal fade" id="createExpertizaModal" tabindex="-1" aria-labelledby="createExpertizaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createExpertizaModalLabel">Create Expertiza</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('expertiza.store') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{$monitoring->id}}" name="shartnoma_id">

                    <div class="modal-body">
                        <!-- Raqami Field -->
                        <div class="mb-3">
                            <label for="expertiza-raqami" class="form-label">Raqami</label>
                            <input type="text" class="form-control" id="expertiza-raqami" name="raqami" required>
                        </div>

                        <!-- Sanasi Field -->
                        <div class="mb-3">
                            <label for="expertiza-sanasi" class="form-label">Sanasi</label>
                            <input type="date" class="form-control" id="expertiza-sanasi" name="sanasi" required>
                        </div>

                        <!-- Tashkilot Nomi Field -->
                        <div class="mb-3">
                            <label for="tashkilot-nomi" class="form-label">Tashkilot Nomi</label>
                            <input type="text" class="form-control" id="tashkilot-nomi" name="tashkilot_nomi"
                                required>
                        </div>

                        <!-- Ekspertiza Xulosa Raqami Field -->
                        <div class="mb-3">
                            <label for="ekspertiza-xulosa-raqami" class="form-label">Ekspertiza Xulosa Raqami</label>
                            <input type="text" class="form-control" id="ekspertiza-xulosa-raqami"
                                name="ekspertiza_xulosa_raqami" required>
                        </div>

                        <!-- Ekspertiza Xulosa Sanasi Field -->
                        <div class="mb-3">
                            <label for="ekspertiza-xulosa-sanasi" class="form-label">Ekspertiza Xulosa Sanasi</label>
                            <input type="date" class="form-control" id="ekspertiza-xulosa-sanasi"
                                name="ekspertiza_xulosa_sanasi" required>
                        </div>

                        <!-- Shaffofdan At Raqami Field -->
                        <div class="mb-3">
                            <label for="shaffofdan-at-raqami" class="form-label">Shaffofdan At Raqami</label>
                            <input type="text" class="form-control" id="shaffofdan-at-raqami"
                                name="shaffofdan_at_raqami" required>
                        </div>

                        <!-- Shaffofdan At Sanasi Field -->
                        <div class="mb-3">
                            <label for="shaffofdan-at-sanasi" class="form-label">Shaffofdan At Sanasi</label>
                            <input type="date" class="form-control" id="shaffofdan-at-sanasi"
                                name="shaffofdan_at_sanasi" required>
                        </div>

                        <!-- Xulosa Izoh Field -->
                        <div class="mb-3">
                            <label for="xulosa-izoh" class="form-label">Xulosa Izoh</label>
                            <textarea name="xulosa_izoh" class="form-control" id="xulosa-izoh" cols="30" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Expertiza</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ДАҚН (ГАСН) Yaratish Modal -->
    <div class="modal fade" id="createDaknGasnModal" tabindex="-1" aria-labelledby="createDaknGasnModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createDaknGasnModalLabel">Create ДАҚН (ГАСН)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('dakn.store') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{$monitoring->id}}" name="shartnoma_id">

                    <div class="modal-body">
                        <!-- Ariza Raqami Field -->
                        <div class="mb-3">
                            <label for="ariza-raqami" class="form-label">Ariza Raqami</label>
                            <input type="text" class="form-control" id="ariza-raqami" name="ariza_raqami" required>
                        </div>

                        <!-- Ariza Sanasi Field -->
                        <div class="mb-3">
                            <label for="ariza-sanasi" class="form-label">Ariza Sanasi</label>
                            <input type="date" class="form-control" id="ariza-sanasi" name="ariza_sanasi" required>
                        </div>

                        <!-- Ko'chirma GASN Raqami Field -->
                        <div class="mb-3">
                            <label for="ko-chirma-gasn-raqami" class="form-label">Ko'chirma GASN Raqami</label>
                            <input type="text" class="form-control" id="ko-chirma-gasn-raqami"
                                name="ko_chirma_gasn_raqami" required>
                        </div>

                        <!-- Ko'chirma GASN Sanasi Field -->
                        <div class="mb-3">
                            <label for="ko-chirma-gasn-sanasi" class="form-label">Ko'chirma GASN Sanasi</label>
                            <input type="date" class="form-control" id="ko-chirma-gasn-sanasi"
                                name="ko_chirma_gasn_sanasi" required>
                        </div>

                        <!-- Izoh Field -->
                        <div class="mb-3">
                            <label for="xulosa-izoh" class="form-label">Izoh</label>
                            <textarea name="xulosa_izoh" class="form-control" id="xulosa-izoh" cols="30" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create ДАҚН (ГАСН)</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
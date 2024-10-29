<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Monitoring;
use App\Models\ArtMaLumotlari;
use App\Models\KengashXulosasi;
use App\Models\EkspertizaXulosasi;
use App\Models\DaknGasnInspection;
use App\Models\Shartnoma;

class MonitoringController extends Controller
{
    public function index()
    {
        $monitorings = Shartnoma::with([
            'kengashXulosasi',
            'ekspertizaXulosasi',
            'daknGasnInspection',
            'artMaLumotlari'
        ])->paginate(10);

        return view('pages.monitoring.index', compact('monitorings'));
    }

    public function art_store(Request $request)
    {
        // Validate request data
        $request->validate([
            'ariza_raqami' => 'required|string|max:255',
            'ariza_sanasi' => 'required|date',
            'art_raqami' => 'required|string|max:255',
            'art_sanasi' => 'required|date',
            'xulosa_izoh' => 'nullable|string'
        ]);

        // Create ArtMaLumotlari record
        $artMaLumotlari = ArtMaLumotlari::create([
            'ariza_raqami' => $request->ariza_raqami,
            'ariza_sanasi' => $request->ariza_sanasi,
            'art_raqami' => $request->art_raqami,
            'art_sanasi' => $request->art_sanasi,
            'xulosa_izoh' => $request->xulosa_izoh,
        ]);

        $shartnoma = Shartnoma::find($request->shartnoma_id);

        if ($shartnoma) {
            $shartnoma->update([
                'art_ma_lumotlari_id' => $artMaLumotlari->id
            ]);
        }

        return redirect()->back()->with('success', 'Apz created successfully');
    }




    // Kengash store method
    public function kengash_store(Request $request)
    {
        $request->validate([
            'ariza_raqami' => 'required|string|max:255',
            'bayon_raqami' => 'required|string|max:255',
            'bayon_sanasi' => 'required|date',
            'bayon_izoh' => 'nullable|string',
            'xulosa_raqami' => 'required|string|max:255',
            'xulosa_sanasi' => 'required|date',
            'xulosa_izoh' => 'nullable|string',
        ]);

        $kengashXulosasi = KengashXulosasi::create([
            'ariza_raqami' => $request->ariza_raqami,
            'bayon_raqami' => $request->bayon_raqami,
            'bayon_sanasi' => $request->bayon_sanasi,
            'bayon_izoh' => $request->bayon_izoh,
            'xulosa_raqami' => $request->xulosa_raqami,
            'xulosa_sanasi' => $request->xulosa_sanasi,
            'xulosa_izoh' => $request->xulosa_izoh,
        ]);

     
        $shartnoma = Shartnoma::find($request->shartnoma_id);

        if ($shartnoma) {
            $shartnoma->update([
                'kengash_xulosasi_id' => $kengashXulosasi->id
            ]);
        }


        return redirect()->back()->with('success', 'Kengash created successfully');
    }


    // Expertiza store method
    public function expertiza_store(Request $request)
    {
        $request->validate([
            'raqami' => 'required|string|max:255',
            'sanasi' => 'required|date',
            'expertiza_comment' => 'nullable|string',
            'tashkilot_nomi' => 'required|string|max:255',
            'ekspertiza_xulosa_raqami' => 'required|string|max:255',
            'ekspertiza_xulosa_sanasi' => 'required|date',
            'shaffofdan_at_raqami' => 'required|string|max:255',
            'shaffofdan_at_sanasi' => 'required|date',
            'xulosa_izoh' => 'nullable|string',
        ]);

        $ekspertizaXulosasi = EkspertizaXulosasi::create([
            'raqami' => $request->raqami,
            'sanasi' => $request->sanasi,
            'expertiza_comment' => $request->expertiza_comment,
            'tashkilot_nomi' => $request->tashkilot_nomi,
            'ekspertiza_xulosa_raqami' => $request->ekspertiza_xulosa_raqami,
            'ekspertiza_xulosa_sanasi' => $request->ekspertiza_xulosa_sanasi,
            'shaffofdan_at_raqami' => $request->shaffofdan_at_raqami,
            'shaffofdan_at_sanasi' => $request->shaffofdan_at_sanasi,
            'xulosa_izoh' => $request->xulosa_izoh,
        ]);

        $shartnoma = Shartnoma::find($request->shartnoma_id);

        if ($shartnoma) {
            $shartnoma->update([
                'ekspertiza_xulosasi_id' => $ekspertizaXulosasi->id
            ]);
        }

        return redirect()->back()->with('success', 'Expertiza created successfully');
    }



    // ДАҚН (ГАСН) store method
    public function dakn_gasn_inspection_store(Request $request)
    {
        $request->validate([
            'ariza_raqami' => 'required|string|max:255',
            'ariza_sanasi' => 'required|date',
            'ko_chirma_gasn_raqami' => 'required|string|max:255',
            'ko_chirma_gasn_sanasi' => 'required|date',
            'xulosa_izoh' => 'nullable|string',
        ]);

        $daknGasnInspection = DaknGasnInspection::create([
            'ariza_raqami' => $request->ariza_raqami,
            'ariza_sanasi' => $request->ariza_sanasi,
            'ko_chirma_gasn_raqami' => $request->ko_chirma_gasn_raqami,
            'ko_chirma_gasn_sanasi' => $request->ko_chirma_gasn_sanasi,
            'xulosa_izoh' => $request->xulosa_izoh,
        ]);

        $shartnoma = Shartnoma::find($request->shartnoma_id);

        if ($shartnoma) {
            $shartnoma->update([
                'dakn_gasn_inspection_id' => $daknGasnInspection->id
            ]);
        }

        return redirect()->back()->with('success', 'Dakn Gasn Inspection created successfully');
    }


    public function create()
    {
        return view('monitoring.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([

            'art_ma_lumotlari_id' => 'nullable|exists:art_ma_lumotlari,id',
            'kengash_xulosasi_id' => 'nullable|exists:kengash_xulosasi,id',
            'ekspertiza_xulosasi_id' => 'nullable|exists:ekspertiza_xulosasi,id',
            'dakn_gasn_inspection_id' => 'nullable|exists:dakn_gasn_inspection,id',
        ]);

        // Create a new monitoring record
        $monitoring = Monitoring::create($validatedData);

        return redirect()->route('monitoring.index')->with('success', 'Monitoring record created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Monitoring  $monitoring
     * @return \Illuminate\Http\Response
     */
    public function show(Monitoring $monitoring)
    {
        // You can implement this method to show a specific monitoring record
        // and its related data.
    }

   
    public function edit($id)
    {
        $monitoring = Shartnoma::find($id);
        $kengash = Shartnoma::find($id);
        $apz = Shartnoma::find($id);
        $monitoring = Shartnoma::find($id);
        return view('pages.monitoring.edit',compact('monitoring','apz','kengash'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Monitoring  $monitoring
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Monitoring $monitoring)
    {
        // Validate input
        $validatedData = $request->validate([

            'art_ma_lumotlari_id' => 'nullable|exists:art_ma_lumotlari,id',
            'kengash_xulosasi_id' => 'nullable|exists:kengash_xulosasi,id',
            'ekspertiza_xulosasi_id' => 'nullable|exists:ekspertiza_xulosasi,id',
            'dakn_gasn_inspection_id' => 'nullable|exists:dakn_gasn_inspection,id',
        ]);

        // Update the monitoring record
        $monitoring->update($validatedData);

        // Redirect to a success page or return a response
        return redirect()->route('monitoring.index')->with('success', 'Monitoring record updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Monitoring  $monitoring
     * @return \Illuminate\Http\Response
     */
    public function destroy(Monitoring $monitoring)
    {
        // Delete the monitoring record
        $monitoring->delete();

        // Redirect to a success page or return a response
        return redirect()->route('monitoring.index')->with('success', 'Monitoring record deleted successfully!');
    }

    // ------------------------------
    public function editShartnoma($id)
    {
        $shartnoma = Shartnoma::findOrFail($id);
        return view('monitoring.edit', compact('shartnoma'));
    }

    public function updateShartnoma(Request $request, $id)
    {
        $request->validate([
            'shartnoma_raqami' => 'required|string',
            'shartnoma_sanasi' => 'required|date',
        ]);

        $shartnoma = Shartnoma::findOrFail($id);
        $shartnoma->update($request->all());

        return redirect()->route('shartnoma.edit', $id)->with('success', 'Shartnoma updated successfully.');
    }

    // Apz Methods
    public function editApz($id)
    {
        $apz = Apz::findOrFail($id);
        return view('monitoring.edit', compact('apz'));
    }

    public function updateApz(Request $request, $id)
    {
        $request->validate([
            'ariza_raqami' => 'required|string',
            'ariza_sanasi' => 'required|date',
            'art_raqami' => 'required|string',
            'art_sanasi' => 'required|date',
            'xulosa_izoh' => 'nullable|string',
        ]);

        $apz = Apz::findOrFail($id);
        $apz->update($request->all());

        return redirect()->route('apz.edit', $id)->with('success', 'Apz updated successfully.');
    }

    // Kengash Methods
    public function editKengash($id)
    {
        $kengash = Kengash::findOrFail($id);
        return view('monitoring.edit', compact('kengash'));
    }

    public function updateKengash(Request $request, $id)
    {
        $request->validate([
            'ariza_raqami' => 'required|string',
            'bayon_raqami' => 'required|string',
            'bayon_sanasi' => 'required|date',
            'bayon_izoh' => 'nullable|string',
            'xulosa_raqami' => 'required|string',
            'xulosa_sanasi' => 'required|date',
            'xulosa_izoh' => 'nullable|string',
        ]);

        $kengash = Kengash::findOrFail($id);
        $kengash->update($request->all());

        return redirect()->route('kengash.edit', $id)->with('success', 'Kengash updated successfully.');
    }

    // Ekspertiza Methods
    public function editExpertiza($id)
    {
        $expertiza = Ekspertiza::findOrFail($id);
        return view('monitoring.edit', compact('expertiza'));
    }

    public function updateExpertiza(Request $request, $id)
    {
        $request->validate([
            'raqami' => 'required|string',
            'sanasi' => 'required|date',
            'tashkilot_nomi' => 'required|string',
            'masul_shaxs' => 'required|string',
        ]);

        $expertiza = Ekspertiza::findOrFail($id);
        $expertiza->update($request->all());

        return redirect()->route('expertiza.edit', $id)->with('success', 'Ekspertiza updated successfully.');
    }
}

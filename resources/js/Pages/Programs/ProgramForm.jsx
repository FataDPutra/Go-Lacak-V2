import React, { useState, useEffect } from "react";
import { Inertia } from "@inertiajs/inertia";

const ProgramForm = ({ existingProgram, resetForm }) => {
    const [namaProgram, setNamaProgram] = useState("");
    const [status, setStatus] = useState("program");
    const [noRek, setNoRek] = useState("");

    useEffect(() => {
        if (existingProgram) {
            setNamaProgram(existingProgram.nama_program || "");
            setStatus(existingProgram.status || "program");
            setNoRek(existingProgram.rekenings?.[0]?.no_rek || "");
        } else {
            resetForm();
        }
    }, [existingProgram]);

    const handleSubmit = (e) => {
        e.preventDefault();
        const data = {
            nama_program: namaProgram,
            status: status,
            no_rek: noRek,
        };
        console.log("Data yang dikirim:", data); // Tambahkan log ini untuk memeriksa data yang dikirim

        if (existingProgram) {
            Inertia.put(`/programs/${existingProgram.id}`, data);
        } else {
            Inertia.post("/programs", data);
        }
    };

    return (
        <form onSubmit={handleSubmit}>
            <div>
                <label htmlFor="nama_program">Nama Program:</label>
                <input
                    type="text"
                    id="nama_program"
                    value={namaProgram}
                    onChange={(e) => setNamaProgram(e.target.value)}
                    required
                />
            </div>

            <div>
                <label htmlFor="status">Status:</label>
                <select
                    id="status"
                    value={status}
                    onChange={(e) => setStatus(e.target.value)}
                >
                    <option value="program">Program</option>
                    <option value="subprogram">Subprogram</option>
                    <option value="kegiatan">Kegiatan</option>
                </select>
            </div>

            <div>
                <label htmlFor="no_rek">Nomor Rekening:</label>
                <input
                    type="text"
                    id="no_rek"
                    value={noRek}
                    onChange={(e) => setNoRek(e.target.value)}
                    required
                />
            </div>

            <button type="submit">
                {existingProgram ? "Simpan Perubahan" : "Tambah Program"}
            </button>
        </form>
    );
};

export default ProgramForm;

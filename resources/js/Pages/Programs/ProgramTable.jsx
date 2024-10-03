import React from "react";
import { Inertia } from "@inertiajs/inertia";

const ProgramTable = ({ programs, setExistingProgram }) => {
    const handleEdit = (program) => {
        setExistingProgram(program);
    };

    const handleDelete = (id) => {
        if (confirm("Are you sure you want to delete this program?")) {
            Inertia.delete(`/programs/${id}`);
        }
    };

    return (
        <div>
            <h2>Daftar Program dan Rekening</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Nama Program</th>
                        <th>Status</th>
                        <th>Nomor Rekening</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {programs.map((program) => (
                        <tr key={program.id}>
                            <td>{program.nama_program}</td>
                            <td>{program.status}</td>
                            <td>
                                {program.rekenings.map((rekening) => (
                                    <div key={rekening.id}>
                                        {rekening.no_rek}
                                    </div>
                                ))}
                            </td>
                            <td>
                                <button onClick={() => handleEdit(program)}>
                                    Edit
                                </button>
                                <button
                                    onClick={() => handleDelete(program.id)}
                                >
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default ProgramTable;

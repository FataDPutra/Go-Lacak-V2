import React, { useState } from "react";
import ProgramForm from "./ProgramForm";
import ProgramTable from "./ProgramTable";

const Index = ({ programs }) => {
    const [existingProgram, setExistingProgram] = useState(null);

    // Fungsi untuk mereset form
    const resetForm = () => {
        setExistingProgram(null); // Hapus program yang sedang di-edit, kembalikan form ke mode create
    };

    return (
        <div>
            <h1>Manajemen Program</h1>
            {/* Form untuk create atau edit program */}
            <ProgramForm
                existingProgram={existingProgram}
                resetForm={resetForm}
            />

            {/* Tabel untuk daftar program */}
            <ProgramTable
                programs={programs}
                setExistingProgram={setExistingProgram}
            />
        </div>
    );
};

export default Index;

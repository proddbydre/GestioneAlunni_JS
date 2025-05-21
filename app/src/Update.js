import { useState } from "react";

export default function Update(props) {
    const [nome, setNome] = useState("");
    const [cognome, setCognome] = useState("");
    const a = props.alunno
    const caricaAlunni = props.caricaAlunni
    // funzione post 
    async function CaricaUpdate() {
        await fetch(`http://localhost:8080/alunni/${a.id}`, {
            method: "POST", 
            headers: { "Content-Type": "application/json"},
            body: JSON.stringify({nome: nome ,cognome: cognome})   
        })
        caricaAlunni()
    }

    return (
        <div>
        
                <div>
                    Nome <input type="text" onChange={(e) => {setNome(e.target.value)}}></input>
                    Cognome <input type="text" onChange={(e) => {setCognome(e.target.value)}}></input>
                    <button onClick={CaricaUpdate}>Aggiorna</button>
                    <button>Annulla</button>
                </div>
            
        </div>

    )
    
}
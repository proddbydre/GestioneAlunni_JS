import { useState } from "react";

export default function Inserisci(props){
    const [scelta, setScelta] = useState(false);
    const [nome, setNome] = useState("");
    const [cognome, setCognome] = useState("");
    const caricaAlunni = props.caricaAlunni

    async function salvaAlunno() {
        const response = await fetch("http://localhost:8080/alunni", {
            method: "POST", 
            headers: { "Content-Type": "application/json"},
            body: JSON.stringify({nome: nome ,cognome: cognome})
        });
        await caricaAlunni()
    }

    return (
        <div>
            {!scelta ?(
                <button onClick={() => {setScelta(true)}}>Inserisci</button>
            ):(
                <div>
                    Nome <input type="text" onChange={(e) => {setNome(e.target.value)}}></input>
                    Cognome <input type="text" onChange={(e) => {setCognome(e.target.value)}}></input>
                    <button onClick={salvaAlunno}>Salva</button>
                    <button onClick={() => {setScelta(false)}}>Annulla</button>
                </div>
            )
        }
        </div>

    )
    
}
import {useState} from "react";

export default function Inserisci()
{
    const [scelta, setScelta] = useState(false);

    async function salvaAlunno()
    {
        await fetch('http://localhost:8080/alunnui', {
            method: "POST",
            headers: {"Content-Type:":"application/json"},
            body: JSON.stringify{(nome: "Claudio", Cognome: "Benve")};
        })
    }

    return(

        {!scelta ? (
            <button onClick={() => (setScelta(true))}>Insersisci</button>
        ):(
            <div>
                Nome <input type="text" onChange={()} </input>
                Cognome <input type="text" onChange={() => setCognome()></input>
                <button></button>
                <button></button>
            </div>
        )}

    );
}
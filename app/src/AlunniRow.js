import { useState } from 'react';
import Update from './Update.js';

export default function Alunni(props) {
    const [scelta, setScelta] = useState(false);
    const [scelta1, setScelta1] = useState(false);
    const [nome, setNome] = useState("");
    const [cognome, setCognome] = useState("");
    const a = props.alunno
    const caricaAlunni = props.caricaAlunni

    console.log(a.id)

    async function cancellaAlunno(){
       await fetch(`http://localhost:8080/alunni/${a.id}`, {method: 'DELETE'})
       caricaAlunni()
    }

    async function CaricaUpdate() {
        await fetch(`http://localhost:8080/alunni/${a.id}`, {
            method: "PUT", 
            headers: { "Content-Type": "application/json"},
            body: JSON.stringify({nome: nome ,cognome: cognome})   
        })
        caricaAlunni()
    }
    return(
        <tr>
        <td>{a.id}</td>
        <td>{a.nome}</td>
        <td>{a.cognome}</td>
        <td>
            {!scelta ?(
                <button onClick={() => {setScelta(true)}}>Delete</button>
                ):(
                    <>
                    sei sicuro?
                    <button onClick={cancellaAlunno}>Si</button>
                    <button onClick={() => {setScelta(false)}}>No</button></>
                )
                }
                </td>
        <td>
            {!scelta1 ?(
                <button onClick={() => {setScelta1(true)}}>Edit</button>
            ):(
                <div>
                    Nome <input type="text" onChange={(e) => {setNome(e.target.value)}}></input>
                    Cognome <input type="text" onChange={(e) => {setCognome(e.target.value)}}></input>
                    <button onClick={CaricaUpdate}>Update</button>
                    <button onClick={() => {scelta1(false)}}>Annulla</button>
                </div>
            )}
        </td>
            
      </tr>
    )
} 
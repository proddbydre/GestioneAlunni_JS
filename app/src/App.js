import './App.css';
import { useState } from 'react';
import Alunni from './AlunniRow';
import Inserisci from './Inserisci';

function App() {
  const [alunni, setAlunni ] = useState([]) 
  const [loading, setLoading] = useState(false);

  async function caricaAlunni(){
    setLoading(true);
    const response = await fetch("http://localhost:8080/alunni",{method:"GET"});
    const data = await response.json();
    setAlunni(data);
    setLoading(false);
  }

  return (
    <div className="App">
      {loading && 
      <div>Caricamento in corso ...</div>
      }
      {!loading && 
      <div>
      {alunni.length === 0 ?  (
        <button onClick={caricaAlunni()}>Carica Alunni</button>
        
        ):(
          <table border="1">
          {alunni.map(a => <Alunni alunno = {a} caricaAlunni={caricaAlunni}/>)}
          </table>
      )}
      <Inserisci caricaAlunni={caricaAlunni}/>
      </div>
    }
    </div>
  );
}

export default App;
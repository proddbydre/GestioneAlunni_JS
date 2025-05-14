import './App.css';
import {useState} from 'react';
import AlunniRow from './AlunniRow';

function App() {
  const [alunni, setAlunni] = useState([]);
  const [loading, setLoading] = useState(false);
  async function caricaAlunni(){
      setLoading(true);
      const response = await fetch ("http://localhost:8080/alunni" , {method: "GET"});
      const data = await response.json();
      setAlunni(data);
      setLoading(false);
  }

  return (
    <div className="App">
      {loading && 
        <div>Caricamento in corso!</div>}
      {!loading &&
        <>
        {alunni.length === 0 ? (
            <button onClick={caricaAlunni}>Carica Alunni</button>
        ):(
          <table border="1px solid black">
            {alunni.map(alunno => 
              <AlunniRow a={alunno} caricaAlunni={caricaAlunni}/>
            )}
          </table>
        )}
        </>
        }
    </div>
  );
}
export default App;
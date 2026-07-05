import { useEffect, useState } from "react";
import { API_BASE } from "./config/api";

export default function App() {
    const [todos, setTodos] = useState([]);

    useEffect(() => {
        fetch(`${API_BASE}/todo/items`)
            .then(res => res.json())
            .then(data => setTodos(data.items));
    }, []);

    return (
        <div>
            <h1>Todos</h1>
            <ul>
                {todos.map(t => (
                    <li key={t.id}>
                        {t.title} {t.completed ? "✓" : ""}
                    </li>
                ))}
            </ul>
        </div>
    );
}

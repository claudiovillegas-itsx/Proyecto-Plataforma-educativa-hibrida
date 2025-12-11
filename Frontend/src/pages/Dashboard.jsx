import React, { useEffect, useState } from 'react'
import { getTasks, createTask, updateTask, deleteTask } from '../services/api'

export default function Dashboard() {
  const [tasks, setTasks] = useState([])
  const [loading, setLoading] = useState(true)
  const [newTitle, setNewTitle] = useState('')

  useEffect(() => { loadTasks() }, [])

  async function loadTasks() {
    setLoading(true)
    const data = await getTasks()
    setTasks(data)
    setLoading(false)
  }

  async function handleCreate(e) {
    e.preventDefault()
    if (!newTitle) return

    const created = await createTask({ title: newTitle })
    setTasks(prev => [created, ...prev])
    setNewTitle('')
  }

  async function handleToggle(task) {
    const updated = await updateTask(task.id, { completed: task.completed ? 0 : 1 })
    setTasks(prev => prev.map(t => (t.id === task.id ? updated : t)))
  }

  async function handleDelete(id) {
    await deleteTask(id)
    setTasks(prev => prev.filter(t => t.id !== id))
  }

  return (
    <div className="min-h-screen p-6">
      <h2 className="text-2xl font-semibold mb-4">Tareas</h2>

      <form className="mb-4 flex gap-2" onSubmit={handleCreate}>
        <input
          value={newTitle}
          onChange={e => setNewTitle(e.target.value)}
          className="flex-1 p-2 border rounded"
          placeholder="Nueva tarea"
        />
        <button className="px-4 py-2 bg-green-600 text-white rounded">
          Crear
        </button>
      </form>

      {loading ? (
        <div>Cargando...</div>
      ) : (
        <ul className="space-y-2">
          {tasks.map(task => (
            <li
              key={task.id}
              className="bg-white p-3 rounded shadow flex items-center justify-between"
            >
              <div>
                <div className={`font-medium ${task.completed ? "line-through text-gray-500" : ""}`}>
                  {task.title}
                </div>
              </div>

              <div className="flex gap-2">
                <button
                  onClick={() => handleToggle(task)}
                  className="px-3 py-1 border rounded"
                >
                  {task.completed ? 'Reabrir' : 'Completar'}
                </button>

                <button
                  onClick={() => handleDelete(task.id)}
                  className="px-3 py-1 border rounded"
                >
                  Borrar
                </button>
              </div>
            </li>
          ))}
        </ul>
      )}
    </div>
  )
}

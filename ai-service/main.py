from fastapi import FastAPI
from pydantic import BaseModel
from google import genai
import os
import uvicorn  # <-- Importamos uvicorn para controlar el arranque

client = genai.Client(api_key=os.environ.get("GEMINI_API_KEY"))

app = FastAPI()

class EmbeddingRequest(BaseModel):
    text: str
    product_id: str | None = None

class SearchRequest(BaseModel):
    query: str
    candidates: list[dict]

class ChatRequest(BaseModel):
    prompt: str
    context: str

@app.get("/")
def root():
    return {"status": "ok", "service": "Tejidos Caymi AI"}

@app.post("/generate-embedding")
def generate_embedding(request: EmbeddingRequest):
    result = client.models.embed_content(
        model="models/gemini-embedding-001",
        contents=request.text,
    )
    return {
        "product_id": request.product_id,
        "embedding": result.embeddings[0].values,
        "model": "models/gemini-embedding-001"
    }

@app.post("/search")
def semantic_search(request: SearchRequest):
    query_embedding = client.models.embed_content(
        model="models/gemini-embedding-001",
        contents=request.query,
    ).embeddings[0].values

    results = []
    for candidate in request.candidates:
        candidate_embedding = client.models.embed_content(
            model="models/gemini-embedding-001",
            contents=candidate["description"],
        ).embeddings[0].values

        similarity = sum(a * b for a, b in zip(query_embedding, candidate_embedding))
        results.append({
            "product_id": candidate["id"],
            "name": candidate["name"],
            "similarity_score": round(similarity, 4)
        })

    results.sort(key=lambda x: x["similarity_score"], reverse=True)
    return {"results": results[:5]}

@app.post("/chat")
def chat(request: ChatRequest):
    response = client.models.generate_content(
        model="models/gemini-2.5-flash",
        contents=request.context + "\n\nUsuario: " + request.prompt,
    )
    return {
        "response": response.text
    }

# 🚀 BLOQUE DE ARRANQUE OBLIGATORIO PARA RENDER
if __name__ == "__main__":
    # Lee el puerto dinámico asignado por Render. Si no existe, usa el 8000 por defecto.
    port = int(os.environ.get("PORT", 8000))
    # 'main:app' asume que tu archivo se llama main.py
    uvicorn.run("main:app", host="0.0.0.0", port=port)
import { openDB } from "libs/idb";

export const dbPromise = openDB("ticTacToeDB", 1, {
  upgrade(db) {
    if (!db.objectStoreNames.contains("games")) {
      db.createObjectStore("games", { keyPath: "id", autoIncrement: true });
    }
  },
});

// Добавить запись об игре
export async function saveGame(gameData) {
  const db = await dbPromise;
  await db.add("games", gameData);
}

// Получить список всех игр
export async function getAllGames() {
  const db = await dbPromise;
  return await db.getAll("games");
}

// Получить игру по ID
export async function getGameById(id) {
  const db = await dbPromise;
  return await db.get("games", id);
}

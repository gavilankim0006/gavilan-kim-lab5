import api, { tokenStore } from "./client";

export async function login(username, password) {
  const { data } = await api.post("/api/auth/login", { username, password });
  tokenStore.setTokens(data.tokens.access_token, data.tokens.refresh_token);
  return data;
}

export async function fetchProfile() {
  const { data } = await api.get("/api/auth/me");
  return data;
}

export async function logout() {
  try {
    await api.post("/api/auth/logout", { refresh_token: tokenStore.refresh });
  } catch {
    /* token may already be invalid — ignore */
  }
  tokenStore.clear();
}

export async function fetchProducts() {
  const { data } = await api.get("/api/products");
  return data.data;
}

export async function fetchProduct(id) {
  const { data } = await api.get(`/api/products/${id}`);
  return data.data;
}

export async function createProduct(payload) {
  const { data } = await api.post("/api/products", payload);
  return data.data;
}

export async function updateProduct(id, payload) {
  const { data } = await api.put(`/api/products/${id}`, payload);
  return data.data;
}

export async function deleteProduct(id) {
  await api.delete(`/api/products/${id}`);
}

import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import Navbar from "../components/Navbar";
import { deleteProduct, fetchProducts } from "../api/products";

export default function ProductList() {
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");

  async function load() {
    setLoading(true);
    setError("");
    try {
      setProducts(await fetchProducts());
    } catch (err) {
      setError(err.response?.data?.error || "Failed to load products.");
    } finally {
      setLoading(false);
    }
  }

  useEffect(() => {
    load();
  }, []);

  async function handleDelete(product) {
    if (!window.confirm(`Delete "${product.product_name}"?`)) return;
    try {
      await deleteProduct(product.id);
      setProducts((prev) => prev.filter((p) => p.id !== product.id));
    } catch (err) {
      alert(err.response?.data?.error || "Delete failed.");
    }
  }

  return (
    <>
      <Navbar />
      <div className="container">
        <div className="page-header">
          <div>
            <h1>Products</h1>
            <p className="subtitle">Manage your products and inventory.</p>
          </div>
          <Link className="add-btn" to="/products/new">+ Add Product</Link>
        </div>

        <div className="card">
          {error && <div className="error">{error}</div>}

          {loading ? (
            <div className="empty">Loading…</div>
          ) : products.length === 0 ? (
            <div className="empty">No products yet. Click “Add Product” to create one.</div>
          ) : (
            <table>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                {products.map((p) => (
                  <tr key={p.id}>
                    <td>{p.id}</td>
                    <td><strong>{p.product_name}</strong></td>
                    <td>{p.description}</td>
                    <td className="price">₱{Number(p.price).toFixed(2)}</td>
                    <td><span className="quantity">{p.quantity} pcs</span></td>
                    <td>
                      <Link className="edit" to={`/products/${p.id}/edit`}>Edit</Link>
                      <button className="delete" onClick={() => handleDelete(p)}>Delete</button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          )}
        </div>
      </div>
    </>
  );
}

import { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import Navbar from "../components/Navbar";
import { createProduct, fetchProduct, updateProduct } from "../api/products";

export default function ProductForm() {
  const { id } = useParams();
  const navigate = useNavigate();
  const isEdit = Boolean(id);

  const [form, setForm] = useState({
    product_name: "",
    description: "",
    price: "",
    quantity: "",
  });
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(isEdit);
  const [submitting, setSubmitting] = useState(false);

  useEffect(() => {
    if (!isEdit) return;
    async function load() {
      try {
        const p = await fetchProduct(id);
        setForm({
          product_name: p.product_name || "",
          description: p.description || "",
          price: p.price ?? "",
          quantity: p.quantity ?? "",
        });
      } catch (err) {
        setError(err.response?.data?.error || "Failed to load product.");
      } finally {
        setLoading(false);
      }
    }
    load();
  }, [id, isEdit]);

  function update(key, value) {
    setForm((prev) => ({ ...prev, [key]: value }));
  }

  async function handleSubmit(e) {
    e.preventDefault();
    setError("");
    setSubmitting(true);
    try {
      const payload = {
        product_name: form.product_name,
        description: form.description,
        price: Number(form.price),
        quantity: Number(form.quantity),
      };
      if (isEdit) {
        await updateProduct(id, payload);
      } else {
        await createProduct(payload);
      }
      navigate("/products");
    } catch (err) {
      const data = err.response?.data;
      if (data?.errors) {
        setError(Object.values(data.errors).join(" "));
      } else {
        setError(data?.error || "Save failed.");
      }
    } finally {
      setSubmitting(false);
    }
  }

  return (
    <>
      <Navbar />
      <div className="container narrow">
        <div className="card form-card">
          <h1>{isEdit ? "Edit Product" : "Add Product"}</h1>
          <p className="subtitle">
            {isEdit ? "Update the information for this product." : "Enter the details of your new product."}
          </p>

          {error && <div className="error">{error}</div>}

          {loading ? (
            <div className="empty">Loading…</div>
          ) : (
            <form onSubmit={handleSubmit}>
              <label>
                Product Name
                <input
                  type="text"
                  value={form.product_name}
                  onChange={(e) => update("product_name", e.target.value)}
                  maxLength={100}
                  required
                />
              </label>

              <label>
                Description
                <textarea
                  value={form.description}
                  onChange={(e) => update("description", e.target.value)}
                />
              </label>

              <label>
                Price
                <input
                  type="number"
                  step="0.01"
                  min="0"
                  value={form.price}
                  onChange={(e) => update("price", e.target.value)}
                  required
                />
              </label>

              <label>
                Quantity
                <input
                  type="number"
                  min="0"
                  step="1"
                  value={form.quantity}
                  onChange={(e) => update("quantity", e.target.value)}
                  required
                />
              </label>

              <div className="buttons">
                <button type="button" className="cancel" onClick={() => navigate("/products")}>
                  Cancel
                </button>
                <button type="submit" disabled={submitting}>
                  {submitting ? "Saving…" : isEdit ? "Update Product" : "Save Product"}
                </button>
              </div>
            </form>
          )}
        </div>
      </div>
    </>
  );
}

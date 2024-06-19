import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import Tag from './components/Tag';
import { BrowserRouter, Route, Routes } from 'react-router-dom';

// FuelPHPのビューから渡されたデータを取得
const initialData = window.initialData;
console.log('initialData', initialData);

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>
    <BrowserRouter>
      <Routes>
        <Route
          path="/pandachord/tag/:tagName"
          element={<Tag initialTags={initialData.tags} initialSongs={initialData.songs} />}
        />
      </Routes>
    </BrowserRouter>
  </React.StrictMode>,
);
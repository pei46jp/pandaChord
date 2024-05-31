import React, {useEffect, useState} from "react";
import SongCard from "./SongCard";
import TagList from "./TagList";


const Tag = ({ pageTitle: initialPageTitle, tags: initialTags, songs: initialSongs }) => {
    const [pageTitle, setPageTitle] = useState(initialPageTitle);
    const [tags, setTags] = useState(initialTags);
    const [songs, setSongs] = useState(initialSongs);

    // console.log('pageTitle', pageTitle);
    // console.log('tags', Array.isArray(tags), tags);
    // console.log('songs', Array.isArray(songs), songs);

    return (
        <div className="container">
            <h2 className="pt-4 text-center">{pageTitle}</h2>
            <div className="container py-3 my-5">
                <div className="row">
                    <div className="col-sm-10">
                        <div className="container">
                            <div className="row">
                                {songs.map((song, index) => (
                                    <SongCard key={index} title={song.title} memo={song.memo} />
                                ))}
                            </div>
                        </div>
                    </div>
                    <div className="col-sm-2">
                        <div className="container">
                            <div className="row">
                                <div className="container my-2">
                                    <TagList tags={tags} />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};


export default Tag;
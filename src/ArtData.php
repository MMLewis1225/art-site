<?php

class ArtData {
    // Mediums 
    public static $mediums = [
        "Painting" => [
            "Acrylic Paint",
            "Watercolor",
            "Oil Paint",
            "Gouache",
            "Tempera",
            "Encaustic"
        ],
        "Drawing" => [
            "Pencil (Graphite)",  
            "Colored Pencils",
            "Charcoal",
            "Pastel",
            "Markers",
            "Alcohol Markers",
            "Crayon",
            "Pen and Ink",
            "Scratchboard"
        ],
        "Other" => [
            "Digital",
            "Collage",
            "Mixed Media",
            "Clay/Sculpture",
            "Printmaking"
        ]
    ];
    
    // Techniques with compatibility data
    public static $techniques = [
        "Dry Media Techniques" => [
            [
                "name" => "Hatching / Cross-Hatching", 
                "description" => "Repeated parallel or intersecting lines for shading.",
                "compatibleMediums" => ["Pencil (Graphite)", "Charcoal", "Colored Pencils", "Pen and Ink"]
            ],
            [
                "name" => "Scumbling", 
                "description" => "Loose, scribbled marks for texture.",
                "compatibleMediums" => ["Pencil (Graphite)", "Charcoal", "Colored Pencils", "Pastel"]
            ],
            [
                "name" => "Stippling", 
                "description" => "Dots of varying density to create value.",
                "compatibleMediums" => ["Pencil (Graphite)", "Pen and Ink", "Markers"]
            ],
            [
                "name" => "Blending", 
                "description" => "Smudging with fingers, stumps, or cloth.",
                "compatibleMediums" => ["Pencil (Graphite)", "Charcoal", "Pastel", "Colored Pencils"]
            ],
            [
                "name" => "Burnishing", 
                "description" => "Polishing colored pencil to a smooth, glossy layer using pressure.",
                "compatibleMediums" => ["Colored Pencils"]
            ],
            [
                "name" => "Lifting / Erasing", 
                "description" => "Subtracting marks for highlights or texture.",
                "compatibleMediums" => ["Pencil (Graphite)", "Charcoal", "Pastel"]
            ],
            [
                "name" => "Feathering", 
                "description" => "Light, soft strokes often used for hair, grass, or fur.",
                "compatibleMediums" => ["Pencil (Graphite)", "Colored Pencils", "Pastel", "Pen and Ink"]
            ]
        ],
        "Wet Media Techniques" => [
            [
                "name" => "Dry Brush", 
                "description" => "Sparse, scratchy strokes with minimal paint.",
                "compatibleMediums" => ["Watercolor", "Acrylic Paint", "Oil Paint", "Gouache"]
            ],
            [
                "name" => "Wet-on-Wet", 
                "description" => "Blending colors directly on wet surface.",
                "compatibleMediums" => ["Watercolor", "Acrylic Paint", "Gouache"]
            ],
            [
                "name" => "Wet-on-Dry", 
                "description" => "Clean edges and layering over dried paint.",
                "compatibleMediums" => ["Watercolor", "Acrylic Paint", "Gouache"]
            ],
            [
                "name" => "Glazing", 
                "description" => "Thin transparent layers over dried paint.",
                "compatibleMediums" => ["Oil Paint", "Acrylic Paint", "Watercolor"]
            ],
            [
                "name" => "Dripping / Splattering", 
                "description" => "Flicking or dropping paint for randomness.",
                "compatibleMediums" => ["Acrylic Paint", "Watercolor", "Ink"]
            ],
            [
                "name" => "Impasto", 
                "description" => "Thick paint application using brush or knife.",
                "compatibleMediums" => ["Oil Paint", "Acrylic Paint"]
            ],
            [
                "name" => "Ink Wash", 
                "description" => "Diluted ink for tonal variation.",
                "compatibleMediums" => ["Pen and Ink"]
            ]
        ],
        "Special Effects Techniques" => [
            [
                "name" => "Salt Crystals", 
                "description" => "Applied to wet watercolor to create crystalline textures.",
                "compatibleMediums" => ["Watercolor"]
            ],
            [
                "name" => "Masking", 
                "description" => "Blocking off areas with tape or resist fluid.",
                "compatibleMediums" => ["Watercolor", "Acrylic Paint", "Gouache"]
            ],
            [
                "name" => "Monoprinting", 
                "description" => "Creating a single print from a painted or inked surface.",
                "compatibleMediums" => ["Printmaking", "Acrylic Paint"]
            ],
            [
                "name" => "Plastic Wrap Textures", 
                "description" => "Pressed into wet paint for fractured organic textures.",
                "compatibleMediums" => ["Watercolor", "Acrylic Paint"]
            ]
        ]
    ];
    
    // Styles with more detailed categories
    public static $styles = [
        "Figurative & Representational" => [
            ["name" => "Realism", "description" => "Detailed and accurate depiction of the subject."],
            ["name" => "Impressionism", "description" => "Capturing light and atmosphere with visible brushstrokes."],
            ["name" => "Expressionism", "description" => "Emotional exaggeration; distorted forms to convey feeling."],
            ["name" => "Surrealism", "description" => "Depicts dreamlike or illogical scenes blending the familiar with the strange."],
            ["name" => "Hyperrealism", "description" => "Extremely detailed and realistic, often mimicking photography."]
        ],
        "Abstract & Interpretive" => [
            ["name" => "Abstract", "description" => "Non-representational, focusing on form, color, and texture."],
            ["name" => "Minimalism", "description" => "Reduced to essential elements—space, shape, and restraint."],
            ["name" => "Gestural", "description" => "Captures movement and energy through physical process."],
            ["name" => "Symbolism", "description" => "Uses metaphors and visual allegory to express deeper meaning."],
            ["name" => "Monochromatic", "description" => "Uses only one color in different values and intensities."]
        ],
        "Graphic & Stylized" => [
            ["name" => "Comic / Cartoon", "description" => "Outlined, simplified, expressive styles for storytelling."],
            ["name" => "Manga / Anime", "description" => "Japanese-influenced illustration with dynamic expressions."],
            ["name" => "Pop Art", "description" => "Bright, high-contrast imagery from mass culture."],
            ["name" => "Graphic / Flat Design", "description" => "Stylized with clean edges and minimal depth."]
        ]
    ];
    
    // Compatible surfaces for different mediums
    public static $surfaces = [
        ["name" => "White Paper", "compatibleMediums" => ["Pencil (Graphite)", "Colored Pencils", "Charcoal", "Pastel", "Markers", "Pen and Ink", "Watercolor"]],
        ["name" => "Toned Paper", "compatibleMediums" => ["Pencil (Graphite)", "Colored Pencils", "Charcoal", "Pastel", "Markers"]],
        ["name" => "Cardboard", "compatibleMediums" => ["Pencil (Graphite)", "Colored Pencils", "Acrylic Paint", "Markers"]],
        ["name" => "Canvas", "compatibleMediums" => ["Oil Paint", "Acrylic Paint", "Mixed Media"]],
        ["name" => "Watercolor Paper", "compatibleMediums" => ["Watercolor", "Gouache", "Pen and Ink", "Mixed Media"]],
        ["name" => "Bristol Board", "compatibleMediums" => ["Pencil (Graphite)", "Colored Pencils", "Markers", "Pen and Ink"]],
        ["name" => "Digital Canvas", "compatibleMediums" => ["Digital"]]
    ];
    
    // Colors schemes with descriptions
    public static $colors = [
        ["name" => "Monochromatic", "description" => "Various tints and shades of a single color"],
        ["name" => "Complementary Colors", "description" => "Colors opposite each other on the color wheel"],
        ["name" => "Analogous Colors", "description" => "Colors adjacent to each other on the color wheel"],
        ["name" => "Warm Colors", "description" => "Reds, oranges, yellows, and warm neutrals"],
        ["name" => "Cool Colors", "description" => "Blues, greens, purples, and cool neutrals"],
        ["name" => "Limited Palette", "description" => "Working with just a few selected colors"],
        ["name" => "Black and White", "description" => "No color, only values of black, white, and gray"],
        ["name" => "Earth Tones", "description" => "Browns, tans, ochres, and natural colors"]
    ];
    
    // Subjects with expanded categories
    public static $subjects = [
        "Person" => [
            "A masked figure",
            "An elderly person",
            "A child with a secret",
            "A dancer in motion",
            "A portrait from an unusual angle",
            "A silhouette against bright light",
            "A weary traveler"
        ],
        "Creature" => [
            "A glowing jellyfish",
            "A mechanical insect",
            "A mythological being",
            "A three-headed animal",
            "A sleeping creature",
            "A hybrid beast"
        ],
        "Object" => [
            "A rusted key",
            "A broken clock",
            "A floating lantern",
            "An antique tool",
            "A reflective surface",
            "A withered plant"
        ],
        "Scene" => [
            "A flooded city",
            "A starlit desert",
            "A cluttered workspace",
            "A misty forest",
            "An underwater ruin",
            "A neon-lit street"
        ],
        "Interaction" => [
            "A hand catching rain",
            "Two silhouettes facing away",
            "A figure reaching toward light",
            "Someone planting a seed",
            "Something emerging from water"
        ]
    ];
    
    // Reference sources with expanded options
    public static $references = [
        "Something in your room",
        "The first red object you see",
        "Look out your window",
        "Something that starts with the letter B",
        "A childhood toy",
        "The last photo in your camera roll",
        "An image from https://unsplash.com/t/nature",
        "A random Wikipedia article illustration",
        "The cover of the book nearest you",
        "A memory from your childhood",
        "A dream you remember"
    ];
    
    // Themes with expanded categories
    public static $themes = [
        "Abstract Ideas" => [
            "Fractured Identity",
            "The Impossible Object",
            "Memory Decay",
            "Infinite Loops",
            "Time Distortion",
            "Cognitive Dissonance"
        ],
        "Narrative Ideas" => [
            "Nature Reclaiming Urban Spaces",
            "The Passage of Time",
            "Hidden Worlds",
            "Mythology/Folklore",
            "Dreams vs. Reality",
            "Artifact from Another Reality"
        ],
        "Duality/Contrast" => [
            "Chaos vs. Order",
            "Isolation vs. Connection",
            "Growth Through Destruction",
            "The Mundane Made Strange",
            "Harmony in Conflict",
            "Artificial vs. Organic"
        ]
    ];
    
    // Expanded moods
    public static $moods = [
        "Peaceful",
        "Surreal",
        "Melancholic",
        "Joyful",
        "Anxious",
        "Mysterious",
        "Playful",
        "Tragic",
        "Hopeful",
        "Isolated",
        "Ethereal",
        "Chaotic",
        "Nostalgic",
        "Introspective",
        "Unsettling"
    ];
}
?>
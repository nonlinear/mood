#!/bin/bash
# Sync inspiration images NAS → Mac Studio
# Usage: ./sync-from-nas.sh

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

SRC="/Volumes/serve/media/pictures/inspiration"
DST="$HOME/Pictures/mood/images"

echo -e "${BLUE}🔍 Checking NAS mount...${NC}"

# Check if NAS is mounted
if [ ! -d "$SRC" ]; then
  echo -e "${RED}❌ NAS not mounted at $SRC${NC}"
  echo ""
  echo "Mount it first with Tailscale:"
  echo "  open smb://100.79.64.118/serve"
  echo "  OR: open smb://media.adal-rigel.ts.net/serve"
  exit 1
fi

echo -e "${GREEN}✅ NAS mounted${NC}"
echo ""
echo -e "${BLUE}Source:${NC} $SRC"
echo -e "${BLUE}Destination:${NC} $DST"
echo ""

# Count files
echo -e "${BLUE}📊 Counting files...${NC}"
SRC_COUNT=$(find "$SRC" -type f \( -iname "*.jpg" -o -iname "*.jpeg" -o -iname "*.png" -o -iname "*.gif" -o -iname "*.webp" \) 2>/dev/null | wc -l | tr -d ' ')
echo -e "${GREEN}Found $SRC_COUNT images on NAS${NC}"
echo ""

# Dry run
echo -e "${BLUE}🔍 Dry run (preview only)...${NC}"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
rsync -avhn --progress "$SRC/" "$DST/" 2>&1 | tail -20
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

read -p "✅ Looks good? Sync for real? (y/N) " -n 1 -r
echo

if [[ $REPLY =~ ^[Yy]$ ]]; then
  echo ""
  echo -e "${BLUE}📦 Syncing images...${NC}"
  rsync -avh --progress "$SRC/" "$DST/" 2>&1
  
  # Count synced files
  DST_COUNT=$(find "$DST" -type f \( -iname "*.jpg" -o -iname "*.jpeg" -o -iname "*.png" -o -iname "*.gif" -o -iname "*.webp" \) 2>/dev/null | wc -l | tr -d ' ')
  DST_SIZE=$(du -sh "$DST" 2>/dev/null | cut -f1)
  
  echo ""
  echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
  echo -e "${GREEN}✅ Sync complete!${NC}"
  echo -e "   ${BLUE}Images:${NC} $DST_COUNT"
  echo -e "   ${BLUE}Size:${NC} $DST_SIZE"
  echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
else
  echo -e "${RED}❌ Sync cancelled${NC}"
fi
